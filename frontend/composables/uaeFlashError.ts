import { ref } from 'vue'

const flashError = ref<string[]>([])

export const useFlashError = () => {
  const setError = (error: string[] | string) => {
    if (Array.isArray(error)) {
      flashError.value = error
    } else {
      flashError.value = [error]
    }

    // Auto-clear after 5 seconds
    setTimeout(() => {
      flashError.value = []
    }, 5000)
  }

  return {
    flashError,
    setError,
  }
}
