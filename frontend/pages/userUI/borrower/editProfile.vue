<template>

    
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">

            <div class="bg-white rounded-t-lg border-b-1 border-gray-300">
                <div class="md:flex justify-between items-center p-5">
                    <div class="">
                        <p class="text-gray-900 font-semibold text-xl">Edit Profile</p>
                        <p class="text-gray-700 font-normal text-md">Update you personal infomation</p>
                    </div>
                    <div class="flex justify-center items-center gap-x-5">
                        <button class="py-2 px-10 bg-gray-400 hover:bg-gray-500 text-gray-900 rounded-lg">Cancel</button>
                        <button class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Save Change</button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-b-lg border-b-1 border-gray-300">
                    <div class="flex justify-start gap-x-10 items-center p-5">
                        <!-- Profile preview -->
                        <div class="w-30 h-30 rounded-full overflow-hidden bg-blue-600 text-white flex items-center justify-center text-2xl font-bold">
                            <img
                            v-if="imageUrl"
                            :src="imageUrl"
                            alt="Profile"
                            class="object-cover w-full h-full"
                            />
                            <span v-else>{{ initials }}</span>
                        </div>

                        <!-- Instructions + Buttons -->
                        <div class="space-y-5">
                            <p class="text-sm text-gray-600 mb-2">
                            Upload a new photo or use your initials. Images should be at least 400×400px.
                            </p>

                            <div class="flex gap-5">
                                <!-- Upload Button -->
                                <input
                                    ref="fileInput"
                                    type="file"
                                    class="hidden"
                                    @change="handleUpload"
                                    accept="image/*"
                                />
                                <button
                                    class="flex items-center px-4 py-2 bg-gray-100 text-gray-800 text-sm rounded hover:bg-gray-200"
                                    @click="$refs.fileInput.click()"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1"></path>
                                    <path d="M12 12v9m0 0l-3-3m3 3l3-3M12 3v9"></path>
                                    </svg>
                                    Upload Photo
                                </button>

                                <!-- Remove Button -->
                                <button
                                    class="flex items-center px-4 py-2 bg-gray-100 text-gray-800 text-sm rounded hover:bg-gray-200"
                                    @click="removePhoto"
                                    :disabled="!imageUrl"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Remove
                                </button>
                            </div>
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
                                <input type="text" id="firstname" v-model="firstname"
                                    class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                                <p v-if="errors.firstname" class="text-red-500 text-sm mt-1">{{ errors.firstname }}</p>
                            </div>
                            <!--last name-->
                            <div class="w-full">
                                <label for="lastname" class="block text-sm font-medium text-gray-900">last Name</label>
                                <input type="text" id="lastname" v-model="lastname"
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
                                <select id="province_city" v-model="form.province_city" class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
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
                                <p v-if="errors.province_city" class="text-red-500 text-sm mt-1">{{ errors.province_city }}</p>
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

    import { ref } from 'vue'
    import { reactive } from 'vue'

    const initials = ref('RL') // Replace with dynamic value as needed
    const imageUrl = ref(null)

    function handleUpload(event) {
    const file = event.target.files[0]
    if (file) {
        imageUrl.value = URL.createObjectURL(file)
    }
    }

    function removePhoto() {
    imageUrl.value = null
    // Optionally clear file input
    const fileInput = document.querySelector('input[type="file"]')
    if (fileInput) fileInput.value = ''
    }

    

const form = reactive({
  firstname: '',
  lastname: '',
  email: '',
  phone_number:'',
  password: '',
  confirmPassword: '',
  agree: false,
})

const errors = reactive({
  firstname: '',
  lastname: '',
  email: '',
  phone_number:'',
  password: '',
  confirmPassword: '',
  agree: '',
})

const validateEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
const phoneRegex = (phone)=> /^\+?[0-9]{9,15}$/.test(phone)
function handlesubmit() {
  // Clear errors
  errors.firstname = ''
  errors.lastname = ''
  errors.email = ''
  errors.phone_number=''
  errors.password = ''
  errors.confirmPassword = ''
  errors.agree = ''

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
    errro.phone_number='phone number is required'
    valid=false
  } else if (!phoneRegex(form.phone_number)) {
    error.phone_number='enter a valid phone number'
    valid=false
  }
  if (!form.password) {
    errors.password = 'Password is required'
    valid = false
  } else if (form.password.length < 8) {
    errors.password = 'Password must be at least 8 characters'
    valid = false
  }

  if (!form.confirmPassword) {
    errors.confirmPassword = 'Confirm password is required'
    valid = false
  } else if (form.confirmPassword !== form.password) {
    errors.confirmPassword = 'Passwords do not match'
    valid = false
  }

  if (!form.agree) {
    errors.agree = 'You must agree with the terms and conditions'
    valid = false
  }

  if (valid) {
    alert('Form submitted!')
    // Optional: send form to backend here
  }
}
</script>