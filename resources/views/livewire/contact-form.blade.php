<div class="container">
    <h2 class="text-center">Contact Us</h2>
    
	
	
	@if ($formSubmitted)
        @if (session()->has('message'))
        <div class="alert alert-success d-flex justify-content-center">
            {{ session('message') }}
        </div>
         @endif
    <div class="d-flex justify-content-evenly">    <button wire:click="resetForm" class="btn btn-secondary">Send Another Message</button>    <a href="{{route('home')}}"><button  class="btn btn-primary">Return to Home Page</button></a> </div>
    @else

    <form wire:submit.prevent="submit">
        @csrf

        <div class="mb-1">
            <label for="name" class="form-label fs-sm">Name</label>
            <input type="text" id="name" wire:model="name" class="form-control form-control-sm @error('name') is-invalid @enderror" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-1">
            <label for="email" class="form-label fs-sm">Email Address</label>
            <input type="email" id="email" wire:model="email" class="form-control form-control-sm @error('email') is-invalid @enderror" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-1">
            <label for="subject" class="form-label fs-sm">Subject</label>
            <select id="subject" wire:model="subject" class="form-select form-select-sm @error('subject') is-invalid @enderror" required>
                <option value="">Select Purpose</option>
                <option value="Report an error">Report an error</option>
                <option value="advertise on study nexus">Advertise on StudyNexus</option>
                <option value="cooperate/business proposition">Cooperate/Business Proposition</option>
                <option value="suggestions">Suggestions</option>
                <option value="media enquiry">Media Enquiry</option>
                <option value="others">Others</option>
            </select>
            @error('subject')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-1">
            <label for="message" class="form-label fs-sm">Message</label>
            <textarea id="message" wire:model="message" class="form-control @error('message') is-invalid @enderror" rows="4" required></textarea>
            @error('message')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

       

        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
	@endif
</div>

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
