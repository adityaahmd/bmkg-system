<footer class="bg-gray-900 text-white mt-16">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">BMKG</h3>
                <p class="text-gray-400">Badan Meteorologi, Klimatologi, dan Geofisika</p>
            </div>
            
            <div>
                <h4 class="font-semibold mb-4">Tentang</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white">Tentang BMKG</a></li>
                    <li><a href="#" class="hover:text-white">Visi & Misi</a></li>
                    <li><a href="#" class="hover:text-white">Kontak</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold mb-4">Layanan</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('products.index') }}" class="hover:text-white">Katalog Data</a></li>
                    <li><a href="{{ route('pricing.index') }}" class="hover:text-white">Paket Layanan</a></li>
                    <li><a href="#" class="hover:text-white">API Documentation</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold mb-4">Legal</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white">Terms & Conditions</a></li>
                    <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-white">FAQ</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; 2026 BMKG. All rights reserved.</p>
        </div>
    </div>
</footer>