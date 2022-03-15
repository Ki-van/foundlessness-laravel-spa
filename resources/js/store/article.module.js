import DataService from '../services/data.service';

export const article = {
    namespaced: true,
    state: {
        articles: [],
        domains: window.domains,
        toModerateArticles: [],
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
        getToModerateArticles({commit}, params = null) {
            return DataService.getModeratedArticles(params).then(
                toModerateArticles => {
                    commit('setToModerateArticles', toModerateArticles);
                    return Promise.resolve(toModerateArticles);
                },
                error => {
                    return Promise.reject(error);
                }
            );
        },
        async getToModerateArticle({commit}, id) {
            let article =  this.state.article.toModerateArticles?.filter(article => article.id === id)[0]
            if(article)
                return article;
            else {
                article = await DataService.getModeratedArticle(id)
                return article;
            }
        },
        async moderateVersion({commit}, version) {
            try {
                const response = await DataService.publishVersion(version.id);
                commit('removeModeratedVersion', version);
                return Promise.resolve(response);
            }catch (e)
            {
                return Promise.reject(e);
            }
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

                    commit('addVersion', response.data);
                    return Promise.resolve(response.data);
                },
                error => {
                    return Promise.reject(error);
                }
            )
        },

        /**
         *
         * @param commit
         * @param params
         * @param fresh
         * @returns {Promise<Array>}
         */
        getDomains({commit}, params = null, fresh = false) {
            if(this.state.article.domains && !fresh)
                return this.state.article.domains;
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
        async getArticle({commit}, id) {
            let article =  this.state.article.articles?.filter(article => article.id === id)[0]
            if(article)
                return article;
            else {
                article = await DataService.getArticle(id)
                commit('addArticle', article);
                return article;
            }
        }

    },
    mutations: {
        setArticles(state, articles) {
            state.articles = articles;
        },
        setToModerateArticles(state, articles) {
            state.toModerateArticles = articles;
        },
        addArticle(state, article) {
            state.articles.push(article);
        },
        addVersion(state, version) {
            let article = state.articles.find(article => article.id === version.article_id);
            if(article) {
                article.versions.unshift({
                    id: version.id,
                    semver: version.semver
                });
            }
        },
        removeModeratedVersion(state, version) {
            let article = state.toModerateArticles.find(article => article.id === version.article_id);
            if(article) {
                article = article.versions.filter(value => value.id !== version.id);
                if(article.versions.length === 0)
                    state.toModerateArticles = state.toModerateArticles.filter(article => article.id !== version.article_id);
            }
        },
        setDomains(state, domains) {
            state.domains = domains;
        },
        setTags(state, tags) {
            state.tags = tags;
        }
    }
};
