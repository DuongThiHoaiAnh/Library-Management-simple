import http from 'k6/http';
import { check, sleep } from 'k6';

export let options = {
    vus: 100, // số lượng người dùng ảo
    duration: '30s', // thời gian test
};

export default function () {
    let res = http.get('https://library-management-gr6-production.up.railway.app/user/search-book-user');
    check(res, {
        'status was 200': (r) => r.status === 200,
        'response time < 2s': (r) => r.timings.duration < 2000,
    });
    sleep(1);
}
