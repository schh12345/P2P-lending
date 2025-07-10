import {ref} from 'vue'

const flashMessage=ref<string | null>(null)
export const useFlash=()=> {
    const setFlash=(msg:string)=> {
        flashMessage.value=msg
        setTimeout(()=> (flashMessage.value=null),3000)
    }

    return {
        flashMessage,
        setFlash,
    }
}