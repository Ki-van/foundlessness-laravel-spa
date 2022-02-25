import axios from 'axios';

class DataService {
    async getDomains() {
        const response = await axios.get('/api/domain');
        if(response && response.data)
            return response.data;
        else throw new Error('Domain fetch failed');
    }

    async getTags() {
        const response = await axios.get('/api/tag');
        if(response && response.data)
            return response.data;
        else throw new Error('Tag fetch failed');
    }

    async createArticle(article) {
        const response = await axios.post('/api/article', article);
        if(response.data)
            return response.data;
    }

    async getArticle(id) {
        const response = await axios.get(`/api/article/${id}`);
        if(response && response.data)
            return response.data.data;
        else
            throw new Error('No article with such id was found');
    }

    async getArticles(params) {
        const response = await axios.get(`/api/article/`);

        return response.data.data;
    }

}

export default new DataService();
