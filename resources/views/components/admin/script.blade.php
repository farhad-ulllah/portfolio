  <!-- Bootstrap core JavaScript-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
  </script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

  <!-- Bootstrap core JavaScript-->

  <!-- Page level plugins -->
  <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
  <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
  {{-- <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
  <!-- Page level custom scripts -->
  {{-- <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
  <script src="https://cdn.ckeditor.com/4.20.1/full/ckeditor.js"></script> --}}

  {{-- <script>
      CKEDITOR.config.devtools_styles =
          '#cke_tooltip { line-height: 20px; font-size: 12px; padding: 5px; border: 2px solid #333; background: #ffffff }' +
          '#cke_tooltip h2 { font-size: 14px; border-bottom: 1px solid; margin: 0; padding: 1px; }' +
          '#cke_tooltip ul { padding: 0pt; list-style-type: none; }';
      $('.editor').each(function(e) {
          CKEDITOR.replace(this.id, {
              filebrowserUploadUrl: "{{ route('image.upload', ['_token' => csrf_token()]) }}",
              filebrowserUploadMethod: "form",
              height: 250,
              baseFloatZIndex: 10005,
              removeButtons: 'PasteFromWord'
          });
      })
  </script> --}}
  @yield('scripts')
