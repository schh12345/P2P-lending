import { useAuthLender } from "./useAuthLender";
import { useRuntimeConfig } from "#app";

export const lenderCookie = async () => {
  interface LenderResponse {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    phone_number: string;
    profile_picture: string;
    province: string;
  }
  const lender = useState<LenderResponse | null>("lender", () => null);
  const token = useAuthLender();
  const config = useRuntimeConfig();

  if (token.value && !lender.value) {
    try {
      lender.value = await $fetch<LenderResponse>(
        `${config.public.apiBase}/lender`,
        {
          headers: {
            Authorization: `Bearer ${token.value}`,
          },
        }
      );
    } catch (error) {
      lender.value = null;
    }
  }
  return { lender };
};
