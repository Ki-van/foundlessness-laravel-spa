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
        setDomains(state, domains) {
            state.domains = domains;
        },
        setTags(state, tags) {
            state.tags = tags;
        }
    }
};
