@if(session()->has('success'))
				<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>

   	  			<script>
   	  				Swal.fire({
					  position: 'top-center',
					  type: 'success',
					  title: 'faite avec succée',
					  showConfirmButton: false,
					  timer: 2000
					})
   	  			</script>
                @endif