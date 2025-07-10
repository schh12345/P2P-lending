<template>
  <div class="w-full min-h-220 mt-0">
    <div class="lg:mx-10 lg:my-5 md:mt-5 sm:mt-5">
      
        <h2 class="text-center lg:text-left text-2xl font-bold font-sans text-gray-900">LoanBridge</h2>
      
    </div>
    <div class="mx-auto max-w-xl mt-0 p-6 rounded-2xl">
      <div>
        <h2 class="mb-2 text-center text-3xl font-bold tracking-tight text-gray-900">Welcome Borrower</h2>
        <p class="text-gray-600 text-center text-md">Join our trust platform, your problem is our community concern</p>
      </div>

      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form @submit.prevent="handleRegister" class="space-y-6">
          <!-- First Name -->
          <div>
            <label for="firstname" class="block text-sm font-medium text-gray-900">First Name</label>
            <input type="text" id="firstname" v-model="form.firstname"
              class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
            <p v-if="errors.firstname" class="text-red-500 text-sm mt-1">{{ errors.firstname }}</p>
          </div>

          <!-- Last Name -->
          <div>
            <label for="lastname" class="block text-sm font-medium text-gray-900">Last Name</label>
            <input type="text" id="lastname" v-model="form.lastname"
              class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
            <p v-if="errors.lastname" class="text-red-500 text-sm mt-1">{{ errors.lastname }}</p>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
            <input type="text" id="email" v-model="form.email"
              class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
            <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
          </div>

          <!-- phone number -->
          <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-900">Phone Number</label>
            <input type="text" id="phone_number" v-model="form.phone_number"
              class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
            <p v-if="errors.phone_number" class="text-red-500 text-sm mt-1">{{ errors.phone_number }}</p>
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
            <input type="password" id="password" v-model="form.password"
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
            <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="confirmPassword" class="block text-sm font-medium text-gray-900">Confirm Password</label>
            <input type="password" id="confirmPassword" v-model="form.confirmPassword"
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
            <p v-if="errors.confirmPassword" class="text-red-500 text-sm mt-1">{{ errors.confirmPassword }}</p>
          </div>

            <!--upload document-->
          <div>
              <!-- <div class="border-b-1 border-gray-300 mb-8">
                  <h2 class="text-xl font-semibold mb-2">Upload Relevant Document</h2>
              </div> -->
              <div class="space-y-5 text-sm">

                  <!--employment status-->
                  <div class="space-y-1">
                      <label class="block text-sm font-medium">Employment Status</label>
                      <select v-model="form.emp_status" class="w-full rounded-md bg-white p-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                          <option value="">Select your employment status</option>
                          <option value="full_time">Full time</option>
                          <option value="full_time">Part time</option>
                          <option value="full_time">Freelancer</option>

                      </select>
                      <p v-if="errors.emp_status" class="text-red-500 text-sm mt-1">{{ errors.emp_status }}</p>
                  </div>

                  <!--monthly income-->
                  <div class="space-y-1">
                      <label class="block text-sm font-medium">Monthly Income</label>
                      <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                          <div class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6">$</div>
                          <input type="number" v-model="form.income"  min="100" max="5000" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" placeholder="0.00" />
                      </div>
                      <p v-if="errors.income" class="text-red-500 text-sm mt-1">{{ errors.income }}</p>
                  </div>

                  <!--upload documnet section-->
                  <div class="space-y-5">

                    <!--upload national identity-->
                    <div class="space-y-1">
                      <!-- Upload Input -->                   
                      <label class="block text-sm font-medium">
                          Upload National Identity
                      </label>
                      
                      <!-- Custom File Input -->
                      <div class="flex items-center justify-start gap-x-3 rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
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
                      <p v-if="errors.imageFile" class="text-red-500 text-sm mt-1">{{ errors.imageFile }}</p>

                      <!-- Hidden real file input -->
                      <input
                        type="file"
                        ref="fileInputRef"
                        @change="handleFileChange"
                        accept="image/*"
                        class="hidden"
                    
                      />

                      <!-- Image preview -->
                      <div v-if="imagePreview" class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Click to enlarge:</p>
                            <img
                              :src="imagePreview ?? undefined"
                              alt="Preview"
                              @click="openModal"
                              class="rounded-lg shadow w-full max-h-64 object-contain cursor-pointer hover:opacity-80 transition"
                            />
                      </div>

                      <!-- Fullscreen Modal -->
                      <div
                            v-if="isModalOpen"
                            class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center"
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
                    </div>


                    <!--upload employee document-->
                    <div class="space-y-1">
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
                  </div>
                  
              </div>




          </div>

          <!-- Terms Checkbox -->
          <div class="mb-6 flex items-start space-x-2">
            <input type="checkbox" id="agree" v-model="form.agree"
              class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="agree" class="text-sm text-gray-700">
              By signing up you agree to our <NuxtLink to="#" class="text-blue-500 font-sans">terms & conditions</NuxtLink> and <NuxtLink to="#" class="text-blue-500 font-sans">Privacy</NuxtLink>
            </label>
          </div>
          <p v-if="errors.agree" class="text-red-500 text-sm mt-1">{{ errors.agree }}</p>

          <!-- Submit Button -->
          <div>
            <button type="submit"
              class="flex w-full justify-center rounded-md bg-gray-900 px-3 py-1.5 text-sm font-semibold text-white shadow hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-600">
              Continue
            </button>
          </div>
          
        </form>
        <div class="flex justify-between mx-2 my-3">
          <p>Already have account?</p>
          <NuxtLink to="/userUI/authentication/borrower/login" class="text-blue-500 text-sans">Login</NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRuntimeConfig, useRouter ,} from '#app'
import {useAuth} from '@/composables/useAuth'

const config = useRuntimeConfig()
const router = useRouter()

const token = useAuth()
// const user = useState<any>('auth_user', () => null) // if needed

const form = reactive({
  firstname: '',
  lastname: '',
  email: '',
  phone_number: '',
  password: '',
  confirmPassword: '',
  imageFileEmp:'',
  imageFile:'',
  income:'',
  emp_status:'',
  agree: false,
})

const errors = reactive({
  firstname: '',
  lastname: '',
  email: '',
  phone_number: '',
  password: '',
  confirmPassword: '',
  agree: '',
  imageFileEmp:'',
  imageFile:'',
  income:'',
  emp_status:'',
})

const imageFile = ref<File | null>(null)
const imageFileEmp = ref<File | null>(null)

// Image handling (identity)
const imagePreview = ref<string | null>(null)
const fileName = ref<string | null>(null)
const fileInputRef = ref<HTMLInputElement | null>(null)

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement
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
const imagePreviewEmp = ref<string | null>(null)
const fileNameEmp = ref<string | null>(null)
const fileInputRefEmp = ref<HTMLInputElement | null>(null)

const handleFileChangeEmp = (event: Event) => {
  const target = event.target as HTMLInputElement
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


const validateEmail = (email: string) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
const validatePhone = (phone: string) => /^0\d{8,9}$/.test(phone)

const handleRegister = async () => {
  // Clear previous errors
  errors.firstname=''
  errors.lastname=''
  errors.email=''
  errors.phone_number=''
  errors.password=''
  errors.confirmPassword=''

  let valid = true

  if (!form.firstname) errors.firstname = 'Firstname is required', valid = false
  if (!form.lastname) errors.lastname = 'Lastname is required', valid = false

  if (!form.email) {
    errors.email = 'Email is required'
    valid = false
  } else if (!validateEmail(form.email)) {
    errors.email = 'Enter a valid email'
    valid = false
  }

  if (!form.phone_number) {
    errors.phone_number = 'Phone number is required'
    valid = false
  } else if (!validatePhone(form.phone_number)) {
    errors.phone_number = 'Enter a valid phone number'
    valid = false
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

  // Stop if form is invalid
  if (!valid) return

  // Submit to Laravel API
  try {

     // Prepare form data
    const formData = new FormData()
    formData.append('identity', imageFile.value as File)
    formData.append('employment', imageFileEmp.value as File)

    console.log(typeof (imageFileEmp.value as File))

    try {
      const res1 = await $fetch<{ identity_path: string; employment_path: string }>(
        `${config.public.sanctum.baseUrl}/storeImage`,
        {
          method: 'POST',
          body: formData,
          headers: {
            Authorization: `Bearer ${token.value}`,
          },
        }
      )

      const identity_path = ref<string>()
      const employment_path = ref<string>()
      console.log(typeof identity_path);

      identity_path.value = res1.identity_path
      employment_path.value = res1.employment_path

      interface RegisterResponse {
        token: string,
        user?: any
      }
      const res = await $fetch<RegisterResponse>(`${config.public.sanctum.baseUrl}/borrower/register`, {
        method: 'POST',
        body: {
          first_name: form.firstname,
          last_name: form.lastname,
          email: form.email,
          phone_number: form.phone_number,
          password: form.password,
          identity_path: identity_path.value,
          employment_path: employment_path.value,
          income: form.income,
          emp_status: form.emp_status,
        },
      })

      if (res && res.token) {
        token.value = res.token
        // user.value = res.user // optional
        alert('Sign up successful')
        router.push('/userUI/authentication/borrower/otp')
      } else {
        alert('Sign up failed: No token returned')
      }
    } catch (err: any) {
      console.error(err)
      alert(err?.data?.message || 'Sign up failed')
    }
  } catch (err: any) {
    console.error(err)
    alert(err?.data?.message || 'Sign up failed')
  }
}
</script>
