@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey App - Create and Manage Surveys with Ease</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <!-- Hero Section -->
        <div class="col-span-12 flex flex-col items-center justify-center py-12 bg-gradient-to-r from-blue-500 to-blue-700 text-white">
            <h1 class="text-4xl font-bold mb-4">Effortless Survey Creation and Management</h1>
            <p class="text-lg mb-6">Build insightful surveys, track responses in real-time, and enhance engagement.</p>
            <a href="{{ route('register') }}" class="btn btn-primary text-white font-medium px-5 py-3">Get Started Now</a>
        </div>

        <!-- Features Overview -->
        <div class="col-span-12 grid grid-cols-12 gap-6 mt-8">
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="box p-5 text-center">
                    <x-base.lucide class="h-[28px] w-[28px] text-primary" icon="clipboard-check" />
                    <h3 class="text-xl font-semibold mt-4">Create Surveys</h3>
                    <p class="text-base text-slate-500 mt-2">Quickly design surveys tailored to your needs with our user-friendly tools.</p>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="box p-5 text-center">
                    <x-base.lucide class="h-[28px] w-[28px] text-success" icon="line-chart" />
                    <h3 class="text-xl font-semibold mt-4">Analyze Responses</h3>
                    <p class="text-base text-slate-500 mt-2">Track results in real-time with detailed analytics and insights.</p>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="box p-5 text-center">
                    <x-base.lucide class="h-[28px] w-[28px] text-warning" icon="user-check" />
                    <h3 class="text-xl font-semibold mt-4">Manage Users</h3>
                    <p class="text-base text-slate-500 mt-2">Add or remove users, assign roles, and manage permissions seamlessly.</p>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="box p-5 text-center">
                    <x-base.lucide class="h-[28px] w-[28px] text-pending" icon="shield-check" />
                    <h3 class="text-xl font-semibold mt-4">Secure & Reliable</h3>
                    <p class="text-base text-slate-500 mt-2">Your data is safe with our industry-standard security protocols.</p>
                </div>
            </div>
        </div>

        <!-- Statistics and User Testimonials -->
        <div class="col-span-12 mt-12 grid grid-cols-12 gap-6">
            <div class="col-span-12 lg:col-span-6">
                <h2 class="text-3xl font-bold text-center">Trusted by 150+ Users Worldwide</h2>
                <div class="mt-5 grid grid-cols-12 gap-6">
                    <div class="intro-y col-span-6 sm:col-span-3 text-center">
                        <div class="box p-5">
                            <div class="text-3xl font-medium">30</div>
                            <p class="text-base text-slate-500">Published Surveys</p>
                        </div>
                    </div>
                    <div class="intro-y col-span-6 sm:col-span-3 text-center">
                        <div class="box p-5">
                            <div class="text-3xl font-medium">3.721</div>
                            <p class="text-base text-slate-500">Responses Gathered</p>
                        </div>
                    </div>
                    <div class="intro-y col-span-6 sm:col-span-3 text-center">
                        <div class="box p-5">
                            <div class="text-3xl font-medium">2.149</div>
                            <p class="text-base text-slate-500">Total Products</p>
                        </div>
                    </div>
                    <div class="intro-y col-span-6 sm:col-span-3 text-center">
                        <div class="box p-5">
                            <div class="text-3xl font-medium">150</div>
                            <p class="text-base text-slate-500">Active Users</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonials Section -->
            <div class="col-span-12 lg:col-span-6 text-center">
                <h2 class="text-3xl font-bold">What Our Users Say</h2>
                <div class="mt-6">
                    <blockquote class="bg-slate-100 p-6 rounded-lg shadow-md">
                        <p class="text-lg">"The best survey tool I've used! The interface is clean, and the analytics are very insightful."</p>
                        <cite class="mt-4 block text-slate-500">— Alex Smith, Product Manager</cite>
                    </blockquote>
                    <blockquote class="bg-slate-100 p-6 rounded-lg shadow-md mt-6">
                        <p class="text-lg">"Creating surveys is a breeze, and I can easily manage my team and view real-time results!"</p>
                        <cite class="mt-4 block text-slate-500">— Jamie Lee, Marketing Specialist</cite>
                    </blockquote>
                </div>
            </div>
        </div>

        <!-- Final Call-to-Action -->
        <div class="col-span-12 flex flex-col items-center justify-center py-8 bg-gradient-to-r from-green-500 to-green-700 text-white mt-12">
            <h2 class="text-3xl font-bold mb-4">Ready to Create Your First Survey?</h2>
            <a href="{{ route('register') }}" class="btn btn-success text-white font-medium px-6 py-3">Sign Up Today</a>
        </div>
    </div>
@endsection
