@extends('layouts.backend') 

@section('content')

<!-- Hero -->
<div class="bg-image studynexus-bg-hero">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Privacy Policy</h1>

            </div>
        </div>
    </div>
</div>
<!-- END Hero -->

<!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
		 <!-- End Breadcrumbs -->

<!-- Page Content -->
<div class="content content-boxed">
   <div class="block block-rounded">
                          
        <div class=" p-4 rounded-3 shadow-sm">
            <h1 class="fw-bold text-primary-dark mb-4">Study Nexus - Privacy Policy</h1>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Introduction</h2>
                <p>Welcome to Study Nexus. We take your privacy seriously and are committed to protecting your personal information. This privacy policy explains how we collect, use, and share information when you visit our website or use our services.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Information Collection and Use</h2>

                <h3 class="h4">Personal Information</h3>
                <p>Personal Information refers to data that can identify you personally, such as your name, email address, phone number, and educational interests. You may be required to provide Personal Information when you register on Study Nexus, subscribe to our newsletter, fill out a contact form, or request information about educational institutions.</p>

                <h3 class="h4">Non-Personal Information</h3>
                <p>We automatically collect certain non-personally identifiable information when you visit our website, such as your IP address, browser type, operating system, referring URLs, and browsing behavior. This information helps us understand how users interact with our website and improve our services.</p>

                <h3 class="h4">Use of Information</h3>
                <ul>
                    <li>Provide and improve our services.</li>
                    <li>Customize your experience on our website.</li>
                    <li>Communicate with you about your inquiries and our services.</li>
                    <li>Send you newsletters and promotional offers (with your consent).</li>
                    <li>Analyze website usage and perform market research.</li>
                    <li>Display relevant advertisements based on your interests.</li>
                </ul>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Information Sharing and Disclosure</h2>

                <h3 class="h4">Third-Party Service Providers</h3>
                <p>We may share your Personal Information with trusted partners, such as Google tools (Search Console, Google Analytics, Google AdSense), who assist us in operating our website, conducting our business, or providing services to you, as long as they agree to keep your information confidential.</p>

                <h3 class="h4">Legal Requirements</h3>
                <p>We may disclose your Personal Information in response to subpoenas, court orders, or other legal processes, or to establish or exercise our legal rights or defend against legal claims.</p>

                <h3 class="h4">Business Transfers</h3>
                <p>In the event that Study Nexus is acquired by or merged with another company, your information may be transferred to the new owners as part of the business transaction. You will be notified via email or a prominent notice on our website of any such change in ownership or control of your Personal Information.</p>

                <h3 class="h4">Advertising Partners</h3>
                <p>We use third-party advertising companies, such as Google AdSense, to serve ads on our website. These companies may use cookies and other tracking technologies to collect information about your visits to our website and other sites to provide personalized advertisements. For more information on how Google AdSense collects and uses data, please refer to their privacy policy.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Cookies and Tracking Technologies</h2>

                <h3 class="h4">Cookies</h3>
                <p>Study Nexus uses cookies to enhance your experience on our website. Cookies are small text files that are stored on your device when you visit a website. They help us remember your preferences, understand how you use our site, and improve our services.</p>

                <h3 class="h4">Managing Cookies</h3>
                <p>You can manage your cookie preferences through your browser settings. However, disabling cookies may affect the functionality of our website and your ability to use certain features.</p>

                <h3 class="h4">Cookie Consent</h3>
                <p>We have implemented a cookie consent mechanism to comply with data protection regulations and give you control over your cookie preferences.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Data Security</h2>

                <h3 class="h4">Security Measures</h3>
                <p>We implement a variety of security measures, including HTTPS, to protect your Personal Information from unauthorized access, use, or disclosure. These measures include physical, electronic, and procedural safeguards.</p>

                <h3 class="h4">No Absolute Guarantee</h3>
                <p>While we strive to protect your Personal Information, we cannot guarantee its absolute security. Inadvertent disclosures may occur despite our best efforts.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Your Rights and Choices</h2>

                <h3 class="h4">Access and Update</h3>
                <p>You have the right to access and update your Personal Information by logging into your account on our website or contacting us directly.</p>

                <h3 class="h4">Opt-Out</h3>
                <p>You may opt out of receiving promotional emails from us by following the unsubscribe instructions included in those emails. However, we may still send you non-promotional communications, such as those about your account or our ongoing business relations.</p>

                <h3 class="h4">Do Not Track Signals</h3>
                <p>Our website does not currently respond to "Do Not Track" signals from your browser.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Changes to This Privacy Policy</h2>
                <p>We may update this privacy policy from time to time to reflect changes in our practices or applicable laws. We will notify you of any significant changes by posting the new policy on our website and updating the effective date. Your continued use of our website after any changes to this policy constitutes your acceptance of the updated terms.</p>
            </section>

            <section class="text-center">
                <h2 class="h3 text-primary-dark">Contact Us</h2>
                <p>If you have any questions or concerns about this privacy policy, please contact us at:</p>
                <p><strong>Email:</strong> <a href="mailto:bridgeyuwa@gmail.com">bridgeyuwa@gmail.com</a></p>
                </section>
        </div>
 
   </div>

</div>
<!-- END Page Content -->

@endsection