<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

include '../includes/header.php';
?>

<div class="container mx-auto py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-blue-600 mb-8 text-center">About Us</h1>
        
        <div class="bg-white rounded-lg shadow-lg p-8">
            <section class="mb-10">
                <p class="text-xl text-gray-700 mb-6 leading-relaxed font-light">
                    Welcome to <?= SITE_NAME ?>, where your clicks make a difference.
                </p>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    We're a community-driven platform that turns everyday ad revenue into monthly charitable donations. 
                    Each month, 50% of all advertising earnings on this website are donated to the charity voted most by you—our users.
                </p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">Our Mission</h2>
                <p class="text-gray-700 leading-relaxed">
                    We turn ad views into charitable donations. Our users watch ads and cast votes to decide which registered charities receive 50% of our monthly ad revenue. Our goal is to build a transparent, people-powered charity support system through the simplest action—visiting a website.
                </p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">How It Works</h2>
                <ol class="list-decimal list-inside space-y-3 text-gray-700 pl-4">
                    <li class="leading-relaxed">We show ads from platforms like Google AdSense.</li>
                    <li class="leading-relaxed">You visit and engage with the content.</li>
                    <li class="leading-relaxed">At the end of each month, we donate 50% of ad revenue to the top-voted charity.</li>
                    <li class="leading-relaxed">We publish the total raised and proof of donation.</li>
                </ol>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">Why Voting Matters</h2>
                <p class="text-gray-700 leading-relaxed">
                    Your vote helps direct real funds to causes that need them. Each vote you cast after watching an ad helps determine which charity receives funding at the end of the month. Charities are rotated and reviewed monthly to ensure we support a diverse range of impactful organizations.
                </p>
                <div class="bg-blue-50 p-4 rounded-lg mt-4">
                    <p class="text-blue-800 font-semibold">Every vote counts!</p>
                    <p class="text-blue-600">Even a single vote can make the difference in which charity receives funding this month.</p>
                </div>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">Transparency & Trust</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We donate 50% of ad revenue to charities based on your votes. We track every dollar. Monthly reports will be available soon.
                </p>
                <div class="bg-gray-100 p-4 rounded-lg flex items-center">
                    <svg class="w-10 h-10 text-blue-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-semibold">Monthly Donation Reports</p>
                        <p class="text-sm text-gray-600">Coming soon - Transparent reports of all donations made</p>
                    </div>
                </div>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">Why We Exist</h2>
                <p class="text-gray-700 leading-relaxed">
                There are millions of compassionate individuals who want to make a difference in the world but feel limited by time, money, or not knowing where to begin. Donate While Watching was built to bridge that gap — to turn something as simple as your time and attention into meaningful change. By watching short ads on our platform, you're helping generate funds that go directly to vetted charities making a real impact. It’s a way for anyone, anywhere, to contribute to causes they care about without opening their wallet. We believe that with the right tools, everyone can be a force for good — and this platform makes that possible.
                </p>
            </section>

            <div class="mt-8 text-center">
                <p class="text-xl font-semibold text-blue-600">Thank you for being part of the change.</p>
                <div class="mt-6">
                    <a href="<?= SITE_URL ?>/public/vote.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                        Start Making a Difference
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