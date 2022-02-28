import axios from 'axios';

class AuthService {
    async login(credentials) {
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('/login', credentials);
        if(response && response.data)
            return response.data.data;
         else throw new Error('Login failed');
    }

    async logout() {
        const response = await axios.get('logout');
        return response.data;
    }

    register(user) {
        return axios.post( 'register', {
            username: user.username,
            email: user.email,
            password: user.password
        });
    }
}

export default new AuthService();
