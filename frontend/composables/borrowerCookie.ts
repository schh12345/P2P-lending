import {useAuth} from '@/composables/useAuth'
import { useRuntimeConfig } from '#app'
export const borrowerCookie = async ()=>{
  interface BorrowerResponse {
    id:number,
    first_name:string,
    last_name:string,
    email:string,
    phone_number:string,
    amount:number,
    credit_score:number,
  }
  const borrower = useState<BorrowerResponse | null >('borrower', () => null)
  const token = useAuth()
  const config=useRuntimeConfig()

  if (token.value && !borrower.value) {
    try {
      borrower.value = await $fetch<BorrowerResponse>(`${config.public.sanctum.baseUrl}/borrower`, {
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      })
    } catch (error) {
      borrower.value = null
    }
  }
  return {borrower}

}