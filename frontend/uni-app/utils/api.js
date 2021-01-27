import { get, post } from './request'
export const login = data => post('/site/login', data)