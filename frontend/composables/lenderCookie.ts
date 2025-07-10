import { useAuthLender } from "./useAuthLender";
import { useRuntimeConfig } from "#app";

export const lenderCookie =async ()=> {
    interface LenderResponse{
       id:number,
       first_name:string,
       last_name:string,
       email:string,
       phone_number:string,
       amount:number,
     }
     const lender = useState<LenderResponse | null >('lender', () => null)
     const token = useAuthLender()
     const config=useRuntimeConfig()
   
     if (token.value && !lender.value) {
       try {
         lender.value = await $fetch<LenderResponse>(`${config.public.sanctum.baseUrl}/lender`, {
           headers: {
             Authorization: `Bearer ${token.value}`,
           },
         })
       } catch (error) {
         lender.value = null
       }
     }
     return {lender}
   
}