import { useRuntimeConfig } from "#app";
import { borrowerProfileData } from "./borrowerProfileData";
import { useAuth } from "./useAuth";
import { useFlashError } from "./uaeFlashError";
export const loanTracking = async () => {
  const token = useAuth();
  const { id } = await borrowerProfileData();
  const config = useRuntimeConfig();
  const { setError, flashError } = useFlashError();
  const laonTrackingRes = ref<string[][]>([]);

  try {
    interface LoanTrackingResponse {
      alert: string[][];
    }
    const res = await $fetch<LoanTrackingResponse>(
      `${config.public.apiBase}/loanTracking/${id}`,
      {
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      }
    );
    if (res && res.alert.length) {
      laonTrackingRes.value = res.alert;
      // Format each alert into a string like "John Doe is 2 day 3h late"
      const formattedAlerts: string[] = laonTrackingRes.value.map(
        ([firstName, lastName, lateTime]) =>
          `you are late ${lateTime} for the fund from ${firstName} ${lastName}`
      );
      setError(formattedAlerts);
    }
  } catch (error) {
    console.error(error);
    setError("Failed to load loan tracking data.");
  }

  return {
    loanTracking,
  };
};
