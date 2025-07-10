import {useCookie} from '#app'

export const useAuthLender= () =>{
    return useCookie<string|null>('lender_token',{
        maxAge:60*60*24, // 1 day
        sameSite:'lax',
        secure:true,
    })
}