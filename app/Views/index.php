<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>crud app using ci-4 with ajax</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
  <!-- add new product modal start -->
  <div class="modal fade" id="add_product_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add New Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" enctype="multipart/form-data" id="add_product_form" novalidate>
          <div class="p-5 modal-body">
            <div class="mb-3">
              <label>Product Title</label>
              <input type="text" name="title" class="form-control" placeholder="Title" required>
              <div class="invalid-feedback">Product title is required!</div>
            </div>

            <div class="mb-3">
              <label>Product Category</label>
              <input type="text" name="category" class="form-control" placeholder="Category" required>
              <div class="invalid-feedback">Product category is required!</div>
            </div>

            <div class="mb-3">
              <label>Product Description</label>
              <textarea name="description" class="form-control" rows="4" placeholder="description" required></textarea>
              <div class="invalid-feedback">Product description is required!</div>
            </div>

            <div class="mb-3">
              <label>Product Image</label>
              <input type="file" name="file" id="image" class="form-control" required>
              <div class="invalid-feedback">Product image is required!</div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="add_product_btn">Add Product</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- add new product modal end -->

  <!-- edit product modal start -->
  <div class="modal fade" id="edit_product_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" enctype="multipart/form-data" id="edit_product_form" novalidate>
          <input type="hidden" name="id" id="pid">
          <input type="hidden" name="old_image" id="old_image">
          <div class="p-5 modal-body">
            <div class="mb-3">
              <label>Product Title</label>
              <input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
              <div class="invalid-feedback">Product title is required!</div>
            </div>

            <div class="mb-3">
              <label>Product Category</label>
              <input type="text" name="category" id="category" class="form-control" placeholder="Category" required>
              <div class="invalid-feedback">Product category is required!</div>
            </div>

            <div class="mb-3">
              <label>Product Description</label>
              <textarea name="description" class="form-control" rows="4" id="description" placeholder="description" required></textarea>
              <div class="invalid-feedback">Product description is required!</div>
            </div>

            <div class="mb-3">
              <label>Product Image</label>
              <input type="file" name="file" class="form-control">
              <div class="invalid-feedback">Product image is required!</div>
              <div id="product_image"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="edit_product_btn">Update Product</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- edit product modal end -->

  <!-- detail product modal start -->
  <div class="modal fade" id="detail_product_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Details of Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img src="" id="detail_product_image" class="img-fluid">
          <h3 id="detail_product_title" class="mt-3"></h3>
          <h5 id="detail_product_category"></h5>
          <p id="detail_product_description"></p>
          <p id="detail_product_created" class="fst-italic"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- detail product modal end -->

  <div class="container">
    <div class="my-4 row">
      <div class="col-lg-12">
        <div class="shadow card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div class="text-secondary fw-bold fs-3">All Products</div>
            <button class="btn btn-dark finalSubmit" style="margin-left: 780px;">Final Submit</button>
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#add_product_modal">Add New Product</button>
          </div>
          <div class="card-body">
            <div class="row" id="show_products">
              <h1 class="my-5 text-center text-secondary">Products Loading..</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(function() {

        // final submit ajax request
        $(".finalSubmit").click(function(e) {
            e.preventDefault();
            Swal.fire({
          title: 'Are you sure?',
          text: "You want to final submit the data in database!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, final submit it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?=base_url('product/finalSubmit')?>',
              method: 'get',
              success: function(response) {
                console.log(response);
                Swal.fire(
                    'Final Submit',
                  response.message,
                  'success'
                )
                fetchAllProducts();
              }
            });
          }
        })
        });


      // add new post ajax request
      $("#add_product_form").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
          $("#add_product_btn").text("Adding...");
          $.ajax({
            url: '<?=base_url('product/add')?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              if (response.error) {
                $("#image").addClass('is-invalid');
                $("#image").next().text(response.message.image);
              } else {
                $("#add_product_modal").modal('hide');
                $("#add_product_form")[0].reset();
                $("#image").removeClass('is-invalid');
                $("#image").next().text('');
                $("#add_product_form").removeClass('was-validated');
                Swal.fire(
                  'Added',
                  response.message,
                  'success'
                );
                fetchAllProducts();
              }
              $("#add_product_btn").text("Add Product");
            }
          });
        }
      });

      // edit post ajax request
      $(document).delegate('.product_edit_btn', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        $.ajax({
          url: '<?=base_url('product/edit/')?>/' + id,
          method: 'get',
          success: function(response) {
            $("#pid").val(response.message.id);
            $("#old_image").val(response.message.image);
            $("#title").val(response.message.title);
            $("#category").val(response.message.category);
            $("#description").val(response.message.description);
            $("#product_image").html('<img src="<?=base_url('uploads/avatar/')?>/' + response.message.image + '" class="mt-2 img-fluid img-thumbnail" width="150">');
          }
        });
      });

      // update post ajax request
      $("#edit_product_form").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
          $("#edit_product_btn").text("Updating...");
          $.ajax({
            url: '<?=base_url('product/update')?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              $("#edit_product_modal").modal('hide');
              Swal.fire(
                'Updated',
                response.message,
                'success'
              );
              fetchAllProducts();
              $("#edit_product_btn").text("Update Product");
            }
          });
        }
      });

      // delete post ajax request
      $(document).delegate('.product_delete_btn', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?=base_url('product/delete/')?>/' + id,
              method: 'get',
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  response.message,
                  'success'
                )
                fetchAllProducts();
              }
            });
          }
        })
      });

      // post detail ajax request
      $(document).delegate('.product_detail_btn', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        $.ajax({
          url: '<?=base_url('product/detail/')?>/' + id,
          method: 'get',
          dataType: 'json',
          success: function(response) {
            $("#detail_product_image").attr('src', '<?=base_url('uploads/avatar/')?>/' + response.message.image);
            $("#detail_product_title").text(response.message.title);
            $("#detail_product_category").text(response.message.category);
            $("#detail_product_description").text(response.message.body);
            $("#detail_product_created").text(response.message.created_at);
          }
        });
      });

      // fetch all products ajax request
      fetchAllProducts();

      function fetchAllProducts() {
        $.ajax({
          url: '<?=base_url('product/fetch')?>',
          method: 'get',
          success: function(response) {
            $("#show_products").html(response.message);
          }
        });
      }
    });
  </script>

</body>

</html>