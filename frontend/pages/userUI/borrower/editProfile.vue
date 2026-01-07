<template>

    
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">

           

            <div class="bg-white rounded-b-lg border-b-1 border-gray-300">
              <div class="space-y-1 p-10">
              <!-- Upload Input -->
              <label class="block text-lg font-medium">Upload you profile</label>

             
              <p v-if="errors.imageFile" class="text-red-500 text-sm mt-1">{{ errors.imageFile }}</p>

              <!-- Hidden File Input -->
              <input
                type="file"
                ref="fileInputRef"
                @change="handleFileChange"
                accept="image/*"
                class="hidden"
              />

             <!-- Circle Preview: Image or Initials -->
            <div class="mt-4 flex justify-start">
              <!-- Show image if profile_path exists -->
              <div
                v-if="imagePreview"
                @click="openModal"
                class="rounded-full shadow w-32 h-32 object-cover cursor-pointer hover:opacity-80 transition overflow-hidden"
              >
                <img
                  :src="imagePreview"
                  alt="Preview"
                  class="w-full h-full object-cover"
                />
              </div>

              <!-- Show initials if no image -->
              <div
                v-else
                :class="`w-32 h-32 rounded-full ${randomBg} flex items-center justify-center text-3xl font-bold text-white shadow`"
              >
                {{ initial_first_name }}{{ initial_last_name }}
              </div>
            </div>

            
           


              <!-- Fullscreen Modal -->
              <div
                v-if="isModalOpen"
                class=" fixed inset-0 z-50 bg-black/80 flex items-center justify-center"
                @click.self="closeModal"
              >
                <img
                  :src="imagePreview ?? undefined"
                  alt="Full View"
                  class="max-w-full max-h-full rounded shadow-xl"
                />
                <button
                  @click="closeModal"
                  class="absolute top-4 right-4 text-white text-2xl bg-gray-700/70 p-2 rounded-full hover:bg-gray-600"
                >
                  &times;
                </button>
              </div>

              <!-- Custom File Input -->
              <div class=" mt-5 flex items-center justify-start gap-x-3 rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                <button
                  type="button"
                  @click="triggerFileInput"
                  class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition"
                >
                  Choose File
                </button>
                <div class="text-2xl object-center text-center">|</div>
                <span class="text-gray-600 text-sm truncate max-w-xs">{{ fileName }}</span>
              </div>
            </div>

            </div>

            <!--change personal infomation-->
            <div class="bg-white rounded-b-lg p-t">
                <div class="p-5">
                    <div>
                        <p class="text-gray-800 text-xl font-semibold">Personal Information</p>
                    </div>
                    <form @submit.prevent="handlesubmit" class="">
                        <div class="flex justify-start gap-x-10 mt-8">
                            <!--first name-->
                            <div class="w-full">
                                <label for="firstname" class="block text-sm font-medium text-gray-900">First Name</label>
                                <input type="text" id="firstname" v-model="form.firstname"
                                    class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                                <p v-if="errors.firstname" class="text-red-500 text-sm mt-1">{{ errors.firstname }}</p>
                            </div>
                            <!--last name-->
                            <div class="w-full">
                                <label for="lastname" class="block text-sm font-medium text-gray-900">last Name</label>
                                <input type="text" id="lastname" v-model="form.lastname"
                                    class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                                <p v-if="errors.lastname" class="text-red-500 text-sm mt-1">{{ errors.lastname }}</p>
                            </div>
                        </div>
                        <!--email-->
                        <div class="mt-8 w-full">
                                <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                                <input type="text" id="email" v-model="form.email"
                                class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                                <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
                        </div>

                        <!-- phone number -->
                        <div class="mt-8 w-full">
                            <label for="phone_number" class="block text-sm font-medium text-gray-900">Phone Number</label>
                            <input type="number" id="phone_number" v-model="form.phone_number"
                            class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                            <p v-if="errors.phone_number" class="text-red-500 text-sm mt-1">{{ errors.phone_number }}</p>
                        </div>
                        <!--imcome-->
                         <div class="mt-8 w-full">
                            <label for="income" class="block text-sm font-medium text-gray-900">Income</label>
                            <input type="number" id="income" v-model="form.income"
                            class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                            <p v-if="errors.income" class="text-red-500 text-sm mt-1">{{ errors.income }}</p>
                        </div>

                        <!--employment-status-->
                        <div class="mt-8 space-y-1">
                        <label class="block text-sm font-medium">Employment Status</label>
                        <select v-model="form.employment_status" class="w-full rounded-md bg-white p-2 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <option value="">Select your employment status</option>
                            <option value="full-time">Full time</option>
                            <option value="part-time">Part time</option>
                            <option value="full_time">Freelancer</option>

                        </select>
                        <p v-if="errors.emp_status" class="text-red-500 text-sm mt-1">{{ errors.emp_status }}</p>
                        </div>


                        <div class="mt-8 space-y-1">
                        <!-- Upload Input -->                   
                        <label class="block text-sm font-medium">
                            Upload Employee Document
                        </label>
                        
                        <!-- Custom File Input -->
                        <div class="flex items-center justify-start gap-x-3 rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <button
                                type="button"
                                @click="triggerFileInputEmp"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition"
                            >
                                Choose File
                            </button>
                            <div class="text-2xl object-center text-center">|</div>
                            <span class="text-gray-600 text-sm truncate max-w-xs">{{ fileNameEmp }}</span>
                        </div>

                        <p v-if="errors.imageFileEmp" class="text-red-500 text-sm mt-1">{{ errors.imageFileEmp }}</p>

                        <!-- Hidden real file input -->
                        <input
                            type="file"
                            ref="fileInputRefEmp"
                            @change="handleFileChangeEmp"
                            accept="image/*"
                            class="hidden"
                            
                        />

                        <!-- Image preview -->
                        <div v-if="imagePreviewEmp" class="mt-4">
                            <p class="text-sm text-gray-500 mb-2">Click to enlarge:</p>
                                <img
                                :src="imagePreviewEmp ?? undefined"
                                alt="Preview"
                                @click="openModalEmp"
                                class="rounded-lg shadow w-full max-h-64 object-contain cursor-pointer hover:opacity-80 transition"
                                />
                        </div>

                        <!-- Fullscreen Modal -->
                        <div
                                v-if="isModalOpenEmp"
                                class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center"
                                @click.self="closeModalEmp"
                            >
                                <img
                                :src="imagePreviewEmp ?? undefined"
                                alt="Full View"
                                class="max-w-full max-h-full rounded shadow-xl"
                                />
                                <button
                                @click="closeModalEmp"
                                class="absolute top-4 right-4 text-white text-2xl bg-gray-700/70 p-2 rounded-full hover:bg-gray-600"
                                >
                                &times;
                                </button>
                        </div>
                        </div>


                        
                        <!--address-->
                        <!-- <div class="mt-8 w-full">
                            <label for="address" class="block text-sm font-medium text-gray-900">address</label>
                            <input type="text" id="address" v-model="form.address"
                            class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                            <p v-if="errors.address" class="text-red-500 text-sm mt-1">{{ errors.address }}</p>
                        </div> -->

                        <!--city-->
                        <div class="md:flex md:justify-start mt-8 gap-x-5">
                            <div class="w-full">
                                <label for="provine_city" class="block text-sm font-medium text-gray-900">Province/City</label>
                                <select id="province_city" v-model="form.province" class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                    <option value="" selected>-- Select Province/City --</option>
                                    <option value="Banteay Meanchey">Banteay Meanchey</option>
                                    <option value="Battambang">Battambang</option>
                                    <option value="Kampong Cham">Kampong Cham</option>
                                    <option value="Kampong Chhnang">Kampong Chhnang</option>
                                    <option value="Kampong Speu">Kampong Speu</option>
                                    <option value="Kampong Thom">Kampong Thom</option>
                                    <option value="Kampot">Kampot</option>
                                    <option value="Kandal">Kandal</option>
                                    <option value="Kep">Kep</option>
                                    <option value="Koh Kong">Koh Kong</option>
                                    <option value="Kratie">Kratie</option>
                                    <option value="Mondulkiri">Mondulkiri</option>
                                    <option value="Phnom Penh">Phnom Penh</option>
                                    <option value="Preah Vihear">Preah Vihear</option>
                                    <option value="Prey Veng">Prey Veng</option>
                                    <option value="Pursat">Pursat</option>
                                    <option value="Ratanakiri">Ratanakiri</option>
                                    <option value="Siem Reap">Siem Reap</option>
                                    <option value="Preah Sihanouk">Preah Sihanouk</option>
                                    <option value="Stung Treng">Stung Treng</option>
                                    <option value="Svay Rieng">Svay Rieng</option>
                                    <option value="Takeo">Takeo</option>
                                    <option value="Oddar Meanchey">Oddar Meanchey</option>
                                    <option value="Pailin">Pailin</option>
                                    <option value="Tboung Khmum">Tboung Khmum</option>
                                </select>
                                <p v-if="errors.province_city" class="text-red-500 text-sm mt-1">{{ errors.province }}</p>
                            </div>

                            <div class="w-full">
                                <label for="provine_city" class="block text-sm font-medium text-gray-900">Country</label>
                                <div class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                    <p>Cambodia</p>
                                </div>
                                
                            </div>
                            
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8">
                            <button type="submit"
                            class="flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-600">
                            Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </div>


    


</template>


<script setup>
    definePageMeta({
        layout:'borrower',
        middleware:'auth'
    })

    import { borrowerProfileData } from '~/composables/borrowerProfileData'

    import { ref } from 'vue'
    import { reactive } from 'vue'
    import { useAuth } from '~/composables/useAuth'
    import { useRuntimeConfig } from '#app'

    let {id, first_name,last_name,email, phone_number, amount, credit_score, initial_first_name, initial_last_name, randomBg,income, employment_path, employment_status,identity_path, profile_picture, province}=await borrowerProfileData()
    const token=useAuth()
    const config=useRuntimeConfig()
    const fullUrl = (path) => `http://localhost:8001${path}`
    const imageFile = ref()
    const imageFileEmp=ref()

// Image handling (identity)
const imagePreview = ref()
const fileName = ref()
const fileInputRef = ref()

if (profile_picture) {
imagePreview.value = fullUrl(profile_picture)
}

const handleFileChange = (event) => {
  const target = event.target
  const file = target.files?.[0]
  if (file) {
    imageFile.value = file
    imagePreview.value = URL.createObjectURL(file)
    fileName.value = file.name
  }
}

const triggerFileInput = () => {
  fileInputRef.value?.click()
}

// Modal for identity image
const isModalOpen = ref(false)
const openModal = () => (isModalOpen.value = true)
const closeModal = () => (isModalOpen.value = false)

// Image handling (employment)
const imagePreviewEmp = ref()
const fileNameEmp = ref()
const fileInputRefEmp = ref()

imagePreviewEmp.value = fullUrl(employment_path)

const handleFileChangeEmp = (event) => {
  const target = event.target
  const file = target.files?.[0]
  if (file) {
    imageFileEmp.value = file
    imagePreviewEmp.value = URL.createObjectURL(file)
    fileNameEmp.value = file.name
  }
}

const triggerFileInputEmp = () => {
  fileInputRefEmp.value?.click()
}

// Modal for employment image
const isModalOpenEmp = ref(false)
const openModalEmp = () => (isModalOpenEmp.value = true)
const closeModalEmp = () => (isModalOpenEmp.value = false)

  

const form = reactive({
  firstname: first_name,
  lastname: last_name,
  email: email,
  phone_number: phone_number,
  income: income,
  employment_status:employment_status,
  province:province,
})
console.log(form.firstname)
const errors = reactive({
  firstname: '',
  lastname: '',
  email: '',
  phone_number:'',
    income:'',
  employment_status:'',
  province:'',
  
})

const validateEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
const phoneRegex = (phone)=> /^\+?[0-9]{9,15}$/.test(phone)
const handlesubmit= async()=> {
  // Clear errors
  errors.firstname = ''
  errors.lastname = ''
  errors.email = ''
  errors.phone_number=''
  errors.income=''
  errors.employment_status=''
  errors.province=''

  let valid = true

  if (!form.firstname) {
    errors.firstname = 'Firstname is required'
    valid = false
  }

  if (!form.lastname) {
    errors.lastname = 'Lastname is required'
    valid = false
  }

  if (!form.email) {
    errors.email = 'Email is required'
    valid = false
  }
      else if (!validateEmail(form.email)) {
      errors.email = 'Enter a valid email'
      valid = false
    }
  
  if (!form.phone_number) {
    errors.phone_number='phone number is required'
    valid=false
  } else if (!phoneRegex(form.phone_number)) {
    errors.phone_number='enter a valid phone number'
    valid=false
  }
 

  if (valid) {
   // Upload files if changed
    if (imageFile.value || imageFileEmp.value) {
      const formData = new FormData()
      if (imageFile.value) formData.append('profileUpload', imageFile.value)
      if (imageFileEmp.value) formData.append('employment', imageFileEmp.value)
    }
  try{
      
      if (imageFile.value || imageFileEmp.value) {
      const formData = new FormData()
        if (imageFile.value) formData.append('profileUpload', imageFile.value)
        if (imageFileEmp.value) formData.append('employment', imageFileEmp.value)
      
      const uploadRes = await $fetch(`${config.public.apiBase}/storeImageForEdit`, {
        method: 'POST',
        body: formData,
        headers: { Authorization: `Bearer ${token.value}` },
      })

      if (uploadRes.profile_path) profile_picture = uploadRes.profile_path
      if (uploadRes.employment_path) employment_path = uploadRes.employment_path
    }
      try {
        await $fetch(`${config.public.apiBase}/editProfileforBorrower`, {
        method: 'POST',
        body: {
            firstname: form.firstname,
            lastname: form.lastname,
            email: form.email,
            phone_number: form.phone_number,
            income: form.income,
            employment_status: form.employment_status,
            profile_path: profile_picture,
            province: form.province,
            employment_path: employment_path,
            borrowerId:id
        },
        headers: {
            Authorization: `Bearer ${token.value}`,
            
        },
        })
        alert ('eidt success')
        navigateTo('/userUI/borrower/profile')
        }catch(error) {
            console.log(error)
        }

  
  // End of try block
  }
  catch (error) {
    console.log(error)
  }

  

    







    // Optional: send form to backend here

}
}
</script>