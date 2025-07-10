<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 p-4">
    <div class="w-full max-w-md">
      <!-- Background decorative elements -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
      </div>

      <!-- Main card -->
      <div class="relative bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 p-8 transform transition-all duration-300 hover:shadow-3xl">
        <!-- Header -->
        <div class="text-center mb-8">
          <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-orange-500 rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
          </div>
          <h1 class="text-3xl font-bold text-white mb-2">Access Restricted</h1>
          <p class="text-gray-300">Admin registration is by invitation only</p>
        </div>

        <!-- Content -->
        <div class="space-y-6">
          <!-- Info box -->
          <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 backdrop-blur-sm">
            <div class="flex items-start">
              <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <div>
                <p class="text-blue-400 font-medium mb-1">Registration Information</p>
                <p class="text-gray-300 text-sm">
                  To register as an admin, please contact our authorized personnel for access approval.
                </p>
              </div>
            </div>
          </div>

          <!-- Contact details -->
          <div class="space-y-4">
            <div class="bg-white/5 rounded-lg p-4 border border-white/10">
              <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
                <span class="text-gray-300 text-sm font-medium">Primary Contact</span>
              </div>
              <p class="text-white font-mono text-sm bg-white/10 rounded px-2 py-1">
                hchhim@paragoniu.edu.kh
              </p>
            </div>

            <div class="bg-white/5 rounded-lg p-4 border border-white/10">
              <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <span class="text-gray-300 text-sm font-medium">Super Admin</span>
              </div>
              <p class="text-white font-mono text-sm bg-white/10 rounded px-2 py-1">
                superadmin@gmail.com
              </p>
            </div>
          </div>

          <!-- Action buttons -->
          <div class="space-y-3">
            <NuxtLink
                to="/admin/login"
                class="group relative w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium rounded-lg hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-900 transform transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
              </svg>
              Back to Login
            </NuxtLink>

            <a
                href="mailto:hchhim@paragoniu.edu.kh?subject=Admin%20Access%20Request&body=Hello,%0D%0A%0D%0AI%20would%20like%20to%20request%20admin%20access%20to%20the%20system.%0D%0A%0D%0AThank%20you."
                class="group relative w-full inline-flex items-center justify-center px-4 py-3 bg-white/10 text-white font-medium rounded-lg border border-white/20 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50 transform transition-all duration-200 hover:scale-105 active:scale-95"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
              Request Access
            </a>
          </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
          <p class="text-gray-400 text-sm">
            Secure admin portal • Access by invitation only
          </p>
        </div>
      </div>
    </div>
  </div>
</template>


<style scoped>
/* Custom shadow for hover effects */
.hover\:shadow-3xl:hover {
  box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
}

/* Glassmorphism effect enhancement */
.backdrop-blur-xl {
  backdrop-filter: blur(20px);
}
</style>