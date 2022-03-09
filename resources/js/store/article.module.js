import DataService from '../services/data.service';

export const article = {
    namespaced: true,
    state: {
        articles: null,
        domains: null,
        tags: null,
    },
    actions: {
        getArticles({commit}, params = null) {
            return DataService.getArticles(params).then(
                articles => {
                    commit('setArticles', articles);
                    return Promise.resolve(articles);
                },
                error => {
                    return Promise.reject(error);
                }
            );
        },
        createArticle({commit}, article){
            return DataService.createArticle(article).then(
                response => {
                    if(response.status === 422) {
                        return Promise.reject(response.data);
                    }
                    return Promise.resolve(response.data.data);
                },
                error => {
                    return Promise.reject(error);
                }
            )
        },

        addVersion({commit}, version){
            return DataService.createVersion(version).then(
                response => {
                    if(response.status === 422) {
                        return Promise.reject(response.data);
                    }
                    commit('addVersion', response.data.data);
                    return Promise.resolve(response.data.data);
                },
                error => {
                    return Promise.reject(error);
                }
            )
        },

        getDomains({commit}, params = null, fresh = false) {
            if(this.state.domains && !fresh)
                return this.state.domains;
            else {
                return DataService.getDomains(params).then(
                    domains => {
                        commit('setDomains', domains.sort((a, b) => b.articles.length - a.articles.length));
                        return Promise.resolve(domains);
                    },
                    error => {
                        return Promise.reject(error);
                    }
                );
            }
        },
        getTags({commit}, params = null, fresh = false) {
            if(this.state.tags && !fresh)
                return this.state.tags;
            else {
                return DataService.getTags().then(
                    tags => {
                        commit('setTags', tags);
                        return Promise.resolve(tags);
                    },
                    error => {
                        return Promise.reject(error);
                    }
                );
            }
        },
        getDomain({commit}, id) {
            let domain =  this.state.article.domains?.filter(domain => domain.id === id)[0]
            if(domain)
                return domain;
            else {
                return DataService.getDomain(id)
            }
        },
        getArticle({commit}, id) {
            let article =  this.state.article.articles?.filter(article => article.id === id)[0]
            if(article)
                return article;
            else {
                return DataService.getArticle(id)
            }
        }

    },
    mutations: {
        setArticles(state, articles) {
            state.articles = articles;
        },
        addArticle(state, article) {
            state.articles.push(article);
        },
        addVersion(state, version) {
            state.articles.find(article => article.id === version.article_id).versions.unshift({
                id: version.id,
                semver: version.semver
            });
        },
        setDomains(state, domains) {
            state.domains = domains;
        },
        setTags(state, tags) {
            state.tags = tags;
        }
    }
};
