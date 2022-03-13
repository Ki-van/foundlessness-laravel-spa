import axios from 'axios';

class AuthService {
    async login(credentials) {
        await axios.get('/sanctum/csrf-cookie');
        return  await axios.post('/login', credentials,{
            validateStatus: status => status >= 200 && status < 300 || status === 422
        });
    }

    async logout() {
        const response = await axios.post('logout', {}, {headers:{
            'Accept': 'application/json'
            }});
        return response.data;
    }

    async register(user) {
        await axios.get('/sanctum/csrf-cookie');
        return await axios.post('/register', user, {
            validateStatus: status => status >= 200 && status < 300 || status === 422
        });
    }
}

export default new AuthService();
