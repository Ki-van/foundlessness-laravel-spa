import DataService from '../services/data.service';

export const article = {
    namespaced: true,
    state: {
        articles: null,
        domains: null,
        tags: null,
    },
    getters: {
      getArticleById: (state) => (id) => {
          let article =  state.article.articles?.filter(article => article.id === id)[0]
          if(article)
              return article;
          else {
              return DataService.getArticle(id)
          }
      }
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
        setDomains(state, domains) {
            state.domains = domains;
        },
        setTags(state, tags) {
            state.tags = tags;
        }
    }
};
