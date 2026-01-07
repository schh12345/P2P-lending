import { lenderCookie } from "./lenderCookie";

export const lenderProfileData=async()=> {
    const {lender}=await lenderCookie()
    const id=lender.value?.id
    const first_name=lender.value?.first_name
    const last_name=lender.value?.last_name
    const email=lender.value?.email
    const phone_number=lender.value?.phone_number
    const profile_picture=lender.value?.profile_picture
    const province=lender.value?.province

    const initial_first_name=computed(()=> first_name?.charAt(0).toUpperCase())
    const initial_last_name=computed(()=> last_name?.charAt(0).toUpperCase())

    const bgColor = ref(['bg-blue-600', 'bg-purple-700', 'bg-green-600', 'bg-pink-500', 'bg-yellow-500', 'bg-red-600'])

    const randomBg = computed(() => 
       first_name ? bgColor.value[first_name.charCodeAt(0) % bgColor.value.length] : 'bg-gray-400'
    )

    return {
        id,
        first_name,
        last_name,
        email,
        phone_number,
        province,
        initial_first_name,
        initial_last_name,
        randomBg,
        profile_picture,
    }
}