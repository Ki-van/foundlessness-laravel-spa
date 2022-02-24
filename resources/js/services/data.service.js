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
}

export default new DataService();
