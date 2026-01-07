import { borrowerCookie } from "./borrowerCookie";

export const borrowerProfileData = async () => {
    const { borrower } = await borrowerCookie();
    const id=borrower.value?.id;
    const first_name = borrower.value?.first_name;
    const last_name=borrower.value?.last_name;
    const email=borrower.value?.email;
    const phone_number=borrower.value?.phone_number;
    const credit_score=borrower.value?.credit_score;
    const amount=borrower.value?.amount
    const income=borrower.value?.income;
    const employment_status=borrower.value?.employment_status;
    const employment_path=borrower.value?.employment_path;
    const identity_path=borrower.value?.identity_path;
    const profile_picture=borrower.value?.profile_picture;
    const province=borrower.value?.province;

    const initial_first_name=computed(()=>first_name?.charAt(0).toUpperCase())
    const initial_last_name=computed(()=> last_name?.charAt(0).toUpperCase())
    const bgColor=['bg-blue-600', 'bg-purple-700', 'bg-green-600', 'bg-pink-500', 'bg-yellow-500', 'bg-red-600']
    // Deterministic hash from name to keep color stable
    const randomBg = computed(() =>
        first_name?bgColor[first_name.charCodeAt(0) % bgColor.length]
        : 'bg-gray-400'
    )

    return {
        id,
        first_name,
        last_name,
        email,
        phone_number,
        amount,
        credit_score,
        initial_first_name,
        initial_last_name,
        randomBg,
        income,
        employment_path,
        employment_status,
        identity_path,
        profile_picture,
        province,
    }
};