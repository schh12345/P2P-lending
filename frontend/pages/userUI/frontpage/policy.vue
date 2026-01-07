Heng, [10/7/25 9:53 ]
<template>
  <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-6">
      <h1 class="text-3xl font-bold text-gray-900">Privacy & Policy</h1>
      <p class="text-gray-600">Last updated: July 9, 2025</p>

      <p class="text-gray-700">
        Welcome to our Peer-to-Peer Lending Marketplace. We are committed to protecting your privacy and ensuring the security of your personal information while providing a safe and transparent lending platform.
      </p>

      <section>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">1. Information We Collect</h2>
        <ul class="list-disc list-inside text-gray-700 space-y-1">
          <li><strong>Personal Information:</strong> Name, email address, phone number, date of birth, address.</li>
          <li><strong>Financial Information:</strong> Bank details, credit score, income, employment details for borrower verification.</li>
          <li><strong>Documents:</strong> Identity documents, employment documents, and other verification materials.</li>
          <li><strong>Usage Data:</strong> IP address, browser type, pages visited, and usage patterns to improve platform performance.</li>
        </ul>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">2. How We Use Your Information</h2>
        <p class="text-gray-700">
          We use your information to:
        </p>
        <ul class="list-disc list-inside text-gray-700 space-y-1">
          <li>Verify your identity and eligibility as a borrower or lender.</li>
          <li>Facilitate peer-to-peer lending transactions on our platform.</li>
          <li>Comply with legal and regulatory requirements.</li>
          <li>Improve and secure our platform services.</li>
          <li>Communicate with you about your account, transactions, and updates.</li>
        </ul>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">3. Sharing of Information</h2>
        <p class="text-gray-700">
          We do <strong>not sell your personal information</strong> to third parties. However, we may share your information with:
        </p>
        <ul class="list-disc list-inside text-gray-700 space-y-1">
          <li>Service providers assisting with platform operations and security.</li>
          <li>Regulatory authorities to comply with legal obligations.</li>
          <li>Other users during transactions, limited to necessary details.</li>
        </ul>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">4. Data Security</h2>
        <p class="text-gray-700">
          We implement security measures to protect your personal data, including encryption, secure servers, and limited access controls. However, no method of transmission over the Internet is 100% secure, and we cannot guarantee absolute security.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">5. Your Rights</h2>
        <p class="text-gray-700">
          You have the right to:
        </p>
        <ul class="list-disc list-inside text-gray-700 space-y-1">
          <li>Access, update, or delete your personal information.</li>
          <li>Withdraw consent for data processing where applicable.</li>
          <li>Request details about the data we hold about you.</li>
        </ul>
        <p class="text-gray-700 mt-2">
          To exercise these rights, please contact us using the contact information below.
        </p>
      </section>

       <!-- New Section -->
      <section>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">7. Late Repayment & Credit Score Impact</h2>
        <p class="text-gray-700">
          To maintain fairness and encourage responsible borrowing, we apply a credit score reduction policy for borrowers who fail to repay their loans on time. This policy helps lenders assess borrower risk and supports a healthy lending environment.
        </p>
        <ul class="list-disc list-inside text-gray-700 space-y-1 mt-2">
          <li><strong>Grace Period:</strong> Borrowers are given a short grace period after the due date to complete repayment without penalty.</li>
          <li><strong>Credit Score Reduction:</strong> If repayment is not made within the grace period, the borrower's credit score will be reduced 5 credit score if borrower late within 5 day. And continue to deduce 5 credit score in the next next 5 day until you payback the total amount to the lenders</li>
          <li><strong>Interest Rate Impact:</strong> In our Peer to Peer Lending Plateform, the interest will set by our system and the borrower can not input by themself. We wiil set the interest rate for every time you make loan request base on your current credit score.</li>
          <li class="ml-10"> Credit Score between 70 to 100 => Interest Rate = 5.0% </li>
          <li class="ml-10"> Credit Score below 70 => Interest Rate = 6.5% </li>
          <li><strong>Redemption:</strong> Borrowers may gradually rebuild their score through timely repayments in future loans.</li>
        </ul>
        <p class="text-gray-700 mt-2">
          This system encourages accountability while allowing room for recovery and continued access to the platform.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">6. Contact Us</h2>
        <p class="text-gray-700">
          If you have any questions or concerns regarding this Privacy Policy or your data, please contact our support team at:
        </p>
        <p class="text-gray-700 font-medium mt-1">
          support@yourplatform.com
        </p>
      </section>

      Heng, [10/7/25 9:53 ]
      <p class="text-gray-700">
        We may update this Privacy Policy periodically. We will notify you of any changes by updating the "Last updated" date at the top of this page.
      </p>
    </div>
  </div>
</template>

<script setup>
definePageMeta({
  layout: 'default'
})
</script>