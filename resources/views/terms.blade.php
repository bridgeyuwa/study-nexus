@extends('layouts.backend') 

@section('content')

<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Terms of Service</h1>

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
            <h1 class="fw-bold text-primary-dark mb-4">StudyNexus - Terms of Service</h1>

            <section class="mb-4">
                <p>This document constitutes the Terms of Service Agreement (the "Agreement"), outlining the terms and conditions for using StudyNexus ("StudyNexus"). By accessing or using StudyNexus, you agree to these terms.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">1. Acceptance of Terms</h2>
                <p>By accessing or using StudyNexus, you acknowledge that you have read, understood, and agree to be bound by this Agreement. If you do not agree with any part of these terms, you must not use StudyNexus. Your continued use of the site constitutes acceptance of any updates or modifications.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">2. Modifications</h2>
                <p>StudyNexus reserves the right to amend or modify this Agreement at any time. We will notify you of significant changes through our website or via email. It is your responsibility to review the Agreement periodically. Continued use of StudyNexus after any changes constitutes acceptance of the modified terms.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">3. Purpose and Limitation of Liability</h2>
                <p>StudyNexus provides general information about educational institutions and programs for personal, non-commercial use only. While we strive to ensure accuracy, we do not guarantee the completeness or reliability of any information. You are responsible for verifying the information and conducting your own research. StudyNexus is not liable for any damages or losses resulting from reliance on the information provided.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">4. Rules for Use</h2>
                <p>You agree not to:</p>
                <ul>
                    <li>Violate any applicable laws or regulations.</li>
                    <li>Harass, cyberstalk, or post offensive or inappropriate content.</li>
                    <li>Upload viruses or engage in unauthorized access.</li>
                    <li>Use automated scripts, bots, or scraping tools to access or extract content.</li>
                    <li>Impersonate any person or entity.</li>
                    <li>Insert unauthorized advertising or promotional material.</li>
                    <li>Attempt to damage, disable, or impair StudyNexus.</li>
                    <li>Circumvent or interfere with the site's security features.</li>
                </ul>
                <p>Users must be of legal age in their jurisdiction or have parental/guardian consent to use the site.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">5. Additional Rules and Policies</h2>
                <p>We may post additional rules, guidelines, or policies on our website. These will become part of this Agreement upon posting and are binding on all users. Please review them regularly.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">6. Disclaimer</h2>
                <p>StudyNexus does not have direct knowledge or affiliation with all educational institutions listed on the platform. Information is provided on an "as is" basis without warranties or representations of any kind. We are not liable for any direct or indirect consequences, loss, damages, or injuries arising from the use of the information on our platform.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">7. Intellectual Property</h2>
                <p>All original content on StudyNexus, including text, graphics, and logos, is protected by intellectual property laws. Unauthorized copying, reproduction, or distribution of this content is prohibited. Trademarks displayed on the site are the property of their respective owners.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">8. Governing Law</h2>
                <p>This Agreement is governed by the laws of Nigeria. Any disputes arising under this Agreement shall be resolved in the courts of Benue, Nigeria.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">9. User Dispute Resolution</h2>
                <p>Disputes should be resolved through arbitration or mediation before pursuing legal action. Specific procedures for dispute resolution will be provided if necessary.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">10. Contact Information</h2>
                <p>For questions or concerns about this Agreement, please contact us at:</p>
                <p><strong>Email:</strong> <a href="mailto:legal@studynexus.ng">legal@studynexus.ng</a></p>
            </section>
        </div>
 
   </div>

</div>
<!-- END Page Content -->

@endsection