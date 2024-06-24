<x-user-layout>

    <x-user-layout>
    
        <div class="container d-flex align-items-center justify-content-between" style="height: 100vh;">
    
            <div class="card w-100">
                <div class="card-header">
                    <h3 class="mt-3">Edit Contact</h3>
                    <div class="d-flex align-items-center mt-3 justify-content-end">
                        <a href="#" class="btn btn-primary rounded-0">Edit Contact</a>
                        <a href="/contact" class="btn btn-outline-primary rounded-0">Contacts</a>
                        <form method="POST" class="my-auto" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary rounded-0">Logout</button>
                        </form>
                    </div>
    
                </div>
    
                <div class="card-body table-responsive">
                    <form action="{{ url("update/$contact->id") }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label>Name</label>
                        <input type="text" name="name" class="form-control my-2" value="{{ old('name') ?? $contact->name }}" required>
                        @error('name')
                            <p class="text-danger"> {{ $message }} </p>
                        @enderror

                        <label>Company</label>
                        <input type="text" name="company" class="form-control my-2" value="{{ old('company') ?? $contact->company }}" required>
                        @error('company')
                            <p class="text-danger"> {{ $message }} </p>
                        @enderror

                        <label>Phone</label>
                        <input type="tel" name="phone_num" class="form-control my-2" value="{{ old('phone_num') ?? $contact->phone_num }}" required>
                        @error('phone_num')
                            <p class="text-danger"> {{ $message }} </p>
                        @enderror

                        <label>Email</label>
                        <input type="email" name="email" class="form-control my-2" value="{{ old('email') ?? $contact->email }}" required>
                        @error('email')
                            <p class="text-danger"> {{ $message }} </p>
                        @enderror

                        <button type="submit" class="btn btn-primary px-lg-5 float-end mt-2">Submit</button>

                        @if (session('status_error') != null)
                            <p class="text-danger"> {{ session('status_error') }} </p>
                        @endif

                    </form>
                </div>
    
            </div>
    
        </div>
    
    </x-user-layout>

</x-user-layout>