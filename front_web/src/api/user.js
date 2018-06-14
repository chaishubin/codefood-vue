import fetch from '@/utils/fetch'
//获取列表信息
export function getlist(offset,length,name,tel,open_id,status) {
    return fetch({
        url: '/manage/userList',
        method: 'post',
        data: {
            offset,
            length,
            name,
            tel,
            open_id,
            status
        }
    })
}
//修改用户状态
export function modify(id,status) {
    return fetch({
        url: '/home/userModify',
        method: 'post',
        data: {
            id,
            status
        }
    })
}
//添加用户
export function adduser(name,tel,password,password_confirmation,email,icon,status,open_id) {
    return fetch({
        url: '/home/userRegister',
        method: 'post',
        data: {
            name,
            tel,
            password,
            password_confirmation,
            email,
            icon,
            status,
            open_id
        }
    })
}
//编辑用户
export function edituser(id,name,tel,password,password_confirmation,email,icon,status,open_id) {
    return fetch({
        url: '/home/userModify',
        method: 'post',
        data: {
            id,
            name,
            tel,
            password,
            password_confirmation,
            email,
            icon,
            status,
            open_id
        }
    })
}
//获取用户信息
export function getuserinfo(id) {
    return fetch({
        url: '/home/userDetail',
        method: 'post',
        data: {
            id
        }
    })
}
//删除用户
export function userdelete(id) {
    return fetch({
        url: '/home/userDelete',
        method: 'post',
        data: {
            id
        }
    })
}