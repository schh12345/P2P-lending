import { ref } from 'vue'
const showSidebar = ref(false)
const activeSection = ref('dashboard')
export const useSideNavLender = ()=> {

  function toggleSidebar() {
    showSidebar.value = !showSidebar.value
  }

  function closeSidebar() {
    showSidebar.value = false
  }

  function setActive(section) {
    activeSection.value = section
  }

  function setActiveAndClose(section) {
    activeSection.value = section
    closeSidebar()
  }

  function getNavClass(section) {
    return activeSection.value === section ? 'bg-blue-200 text-blue-700 border-2 border-blue-600' : ''
  }

  function getMobileNavClass(section) {
    return activeSection.value === section ? 'bg-blue-300 text-blue-700' : ''
  }
  return {
    showSidebar,
    activeSection,
    toggleSidebar,
    closeSidebar,
    setActiveAndClose,
    setActive,
    getNavClass,
    getMobileNavClass,
  }

}