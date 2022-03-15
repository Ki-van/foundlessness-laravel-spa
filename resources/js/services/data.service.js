import axios from 'axios';

class DataService {
    async getDomains() {
        const response = await axios.get('/api/domain');
        if(response && response.data)
            return response.data.data;
        else throw new Error('Domain fetch failed');
    }

    async getTags() {
        const response = await axios.get('/api/tag');
        if(response && response.data)
            return response.data;
        else throw new Error('Tag fetch failed');
    }

    async createArticle(article) {
        return await axios.post('/api/article', article, {
            validateStatus: status => status >= 200 && status < 300 || status === 422
        });
    }

    async createVersion(version) {
        return await axios.post('/api/version', version, {
            validateStatus: status => status >= 200 && status < 300 || status === 422
        });
    }

    async createMark(mark) {
        const response = await axios.post('/api/mark', mark);
        if(response.data)
            return response.data;
    }

    async updateMark(mark_id, value) {
        const response = await axios.put('/api/mark/'+mark_id, {
            value: value
        });
        if(response.data)
            return response.data;
    }

    async deleteMark(mark_id) {
        const response = await axios.delete('/api/mark/' + mark_id);
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
    async getModeratedArticles() {
        const response = await axios.get(`/api/moderation`);
        return response.data.data;
    }

    async publishVersion(id) {
        const response = await axios.put(`/api/version/${id}`, {
            version_status_id: 1
        });
        return response;
    }

    async getModeratedArticle(id) {
        const response = await axios.get(`/api/moderation/${id}`);
        if(response && response.data)
            return response.data.data;
        else
            throw new Error('No article with such id was found');
    }

    async getVersion(id) {
        const response = await axios.get(`/api/version/${id}`);
        if(response && response.data)
            return response.data.data;
        else
            throw new Error('No version with such id was found');
    }

    async getDomain(id) {
        const response = await axios.get(`/api/domain/${id}`);
        if(response && response.data)
            return response.data.data;
        else
            throw new Error('No domain with such id was found');
    }

    async getArticles(params) {
        const response = await axios.get(`/api/article/`);

        return response.data.data;
    }

    async createComment(comment) {
        const response = await axios.post('/api/comment', comment);
        if(response.data && response.data)
            return response.data.data;
    }
}

export default new DataService();
