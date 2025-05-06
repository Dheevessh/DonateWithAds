<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

include '../includes/header.php';
?>

<div class="container mx-auto py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-blue-600 mb-8 text-center">Privacy Policy</h1>
        
        <div class="bg-white rounded-lg shadow-lg p-8">
            <section class="mb-6">
                <p class="text-gray-700 mb-4">
                    <strong>Effective Date:</strong> [Insert Date]
                </p>
                <p class="text-gray-700 mb-4">
                    This Privacy Policy explains how <?= SITE_NAME ?> collects, uses, and protects your information when you use our website.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">Information We Collect</h2>
                <p class="text-gray-700 mb-4">
                    We do not collect personally identifiable information unless you contact us voluntarily (e.g., via email or a contact form). However, we may automatically collect:
                </p>
                <ul class="list-disc ml-6 mb-4 text-gray-700 space-y-1">
                    <li>Browser type and version</li>
                    <li>IP address</li>
                    <li>Pages visited</li>
                    <li>Time spent on pages</li>
                    <li>Referring website</li>
                </ul>
                <p class="text-gray-700">
                    This is done via analytics tools (like Google Analytics) and third-party ad services.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">Cookies and Tracking</h2>
                <p class="text-gray-700 mb-4">
                    We use cookies to:
                </p>
                <ul class="list-disc ml-6 mb-4 text-gray-700 space-y-1">
                    <li>Provide basic website functionality</li>
                    <li>Improve user experience</li>
                    <li>Display personalized advertisements via Google AdSense</li>
                </ul>
                <p class="text-gray-700">
                    You can disable cookies in your browser settings.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">Google AdSense</h2>
                <p class="text-gray-700 mb-4">
                    Third-party vendors, including Google, use cookies to serve ads based on your prior visits to this and other websites. Google's use of advertising cookies enables it and its partners to serve ads based on your visit to our site and/or other sites on the internet.
                </p>
                <p class="text-gray-700 mb-4">
                    You may opt out of personalized advertising by visiting:
                    <a href="https://www.google.com/settings/ads" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">Google Ads Settings</a>
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">Data Sharing</h2>
                <p class="text-gray-700 mb-4">
                    We do not sell or share your personal data with third parties, except for:
                </p>
                <ul class="list-disc ml-6 mb-4 text-gray-700 space-y-1">
                    <li>Legal requirements</li>
                    <li>Hosting providers or analytics tools</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">External Links</h2>
                <p class="text-gray-700">
                    Our website may link to third-party websites. We are not responsible for their content or privacy practices.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">Updates</h2>
                <p class="text-gray-700">
                    We may update this Privacy Policy occasionally. We encourage you to review it periodically.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">Contact</h2>
                <p class="text-gray-700">
                    If you have questions about this Privacy Policy, contact us at:
                    <a href="mailto:your@email.com" class="text-blue-600 hover:underline">your@email.com</a>
                </p>
            </section>

            <div class="mt-10 p-6 bg-blue-50 rounded-lg text-center">
                <p class="text-gray-700">
                    By using our website, you consent to the terms of this Privacy Policy.
                </p>
                <div class="mt-4">
                    <a href="<?= SITE_URL ?>/public/contact.php" class="text-blue-600 hover:underline">
                        Contact us with any questions →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<style>
.charity-description a {
    color: #2563EB;
    text-decoration: none;
}
.charity-description a:hover {
    text-decoration: underline;
}
</style> 