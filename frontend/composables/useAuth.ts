import { useCookie } from '#app'

export const useAuth = () => {
  return useCookie<string | null>('auth_token', {
    maxAge: 60 * 60 * 24, // 1d
    sameSite: 'lax',
    secure: true,
  })
}