</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Map initialization if coordinates exist
        @if(isset($serviceRequest->location_latitude) && isset($serviceRequest->location_longitude))
            // This is a placeholder for map initialization
            // In a real implementation, you would use Google Maps, Mapbox, or Leaflet
            const mapElement = document.getElementById('map');
            if (mapElement) {
                // Initialize map here
                console.log('Map would be initialized with coordinates: {{ $serviceRequest->location_latitude }}, {{ $serviceRequest->location_longitude }}');
            }
        @endif
        
        // Star rating functionality
        const ratingStars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('rating-input');
        
        if (ratingStars.length > 0 && ratingInput) {
            ratingStars.forEach(star => {
                star.addEventListener('click', () => {
                    const rating = parseInt(star.dataset.rating);
                    ratingInput.value = rating;
                    
                    // Update star appearance
                    ratingStars.forEach((s, index) => {
                        const starIcon = s.querySelector('i');
                        if (index < rating) {
                            starIcon.className = 'fas fa-star';
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300', 'dark:text-gray-600');
                        } else {
                            starIcon.className = 'far fa-star';
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300', 'dark:text-gray-600');
                        }
                    });
                });
            });
        }
    });
</script>
@endsection
@endsection
