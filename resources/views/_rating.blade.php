<script>
    // progressbar.js@1.0.0 version is used
    // Docs: http://progressbarjs.readthedocs.org/en/1.0.0/
    @if($event)
    window.livewire.on('gamewithRatingAdded', params => { @endif
        @if($event)
        var progressBarContainer1= document.getElementById(params.slug);
        @else
        var progressBarContainer1= document.getElementById('{{$slug}}')
    @endif
    var bar = new ProgressBar.Circle(progressBarContainer1, {
        color: '#aaa',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 6,
        trailWidth: 3,
        easing: 'easeInOut',
        duration: 2500,
        TrailColor: '#4A5568',
        text: {
            autoStyleContainer: false
        },
        from: {
            color: '#FFCC66',
            width: 6
        },
        to: {
            color: '#FFCC66',
            width: 6
        },
        // Set default step function for all animate calls
        step: function(state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);

            var value = Math.round(circle.value() * 100);
            if (value === 0) {
                circle.setText('0%');
            } else {
                circle.setText(value + '%');
            }

        }
    });
    bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar.text.style.fontSize = '18px';
    bar.text.style.color = 'white';
@if($event)
    bar.animate(params.rating);
    @else
    bar.animate({{$rating}}/100);
    @endif
@if($event) 
})
@endif

</script>