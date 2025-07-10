import { defineStore } from 'pinia'
import axios from 'axios'
import { useRuntimeConfig } from '#imports'

export const useUser = defineStore('user', {
    state: () => ({
        token: null as string | null,
        fullName: '',
        username: '',
        gmail: '',
        phoneNumber: '',
        bio: '',
        profilePictureUrl: ''
    }),

    getters: {
        isAuthenticated: (state) => !!state.token,
        userProfile: (state) => ({
            fullName: state.fullName,
            username: state.username,
            gmail: state.gmail,
            phoneNumber: state.phoneNumber,
            bio: state.bio,
            profilePictureUrl: state.profilePictureUrl
        })
    },

    actions: {
        initializeFromStorage() {
            if (process.client) {
                this.token = localStorage.getItem('auth_token')
                this.fullName = localStorage.getItem('fullName') || ''
                this.username = localStorage.getItem('username') || ''
                this.gmail = localStorage.getItem('gmail') || ''
                this.phoneNumber = localStorage.getItem('phoneNumber') || ''
                this.bio = localStorage.getItem('bio') || ''
                this.profilePictureUrl = localStorage.getItem('profilePictureUrl') || ''
            }
        },

        setToken(token: string) {
            this.token = token
            if (process.client) localStorage.setItem('auth_token', token)
        },

        setUserProfile(profile: any) {
            this.fullName = profile.fullName || profile.full_name || ''
            this.username = profile.username || ''
            this.gmail = profile.gmail || profile.email || ''
            this.phoneNumber = profile.phoneNumber || profile.phone_number || ''
            this.bio = profile.bio || ''
            this.profilePictureUrl = profile.profilePictureUrl || profile.profile_picture_url || ''

            if (process.client) {
                localStorage.setItem('fullName', this.fullName)
                localStorage.setItem('username', this.username)
                localStorage.setItem('gmail', this.gmail)
                localStorage.setItem('phoneNumber', this.phoneNumber)
                localStorage.setItem('bio', this.bio)
                localStorage.setItem('profilePictureUrl', this.profilePictureUrl)
            }
        },

        login(response: any) {
            this.setToken(response.token)
            this.setUserProfile(response.admin || response.user)
        },

        async updateProfile(newProfile: any) {
            try {
                const config = useRuntimeConfig()
                const response = await axios.put(`${config.public.apiBase}/update-profile`, {
                    full_name: newProfile.fullName,
                    username: newProfile.username,
                    email: newProfile.gmail,
                    phone_number: newProfile.phoneNumber,
                    bio: newProfile.bio,
                    profile_picture_url: newProfile.profilePictureUrl
                }, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })

                const updatedProfile = response.data.admin || response.data.data
                this.setUserProfile(updatedProfile)
                return response.data
            } catch (error) {
                console.error('❌ Profile update failed:', error)
                throw error
            }
        },

        async fetchProfile() {
            try {
                const config = useRuntimeConfig()
                const response = await axios.get(`${config.public.apiBase}/profile`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        'Accept': 'application/json'
                    }
                })

                if (response.data.success) {
                    const profile = response.data.data
                    this.setUserProfile(profile)
                }

                return response.data
            } catch (error) {
                console.error('❌ Failed to fetch profile:', error)
                throw error
            }
        },

        logout() {
            this.token = null
            this.fullName = ''
            this.username = ''
            this.gmail = ''
            this.phoneNumber = ''
            this.bio = ''
            this.profilePictureUrl = ''

            if (process.client) {
                localStorage.removeItem('auth_token')
                localStorage.removeItem('fullName')
                localStorage.removeItem('username')
                localStorage.removeItem('gmail')
                localStorage.removeItem('phoneNumber')
                localStorage.removeItem('bio')
                localStorage.removeItem('profilePictureUrl')
            }
        }
    }
})