


<?php $__env->startSection('content'); ?>

  <!-- Main content -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Редактировать заказ</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Главная</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row ">
        <form action="<?php echo e(route('admin.sale.update', $soldOrder->id)); ?>" method="post">
          <?php echo csrf_field(); ?> 
          <?php echo method_field('PATCH'); ?>

          <div class="form-group ">
            <input type="text" name="customer_to" class="form-control" placeholder="Имя" value="<?php echo e($soldOrder->customer_to ?? old('customer_to')); ?>">
          </div>

          <div class="form-group ">
            <input type="text" name="customer_email" class="form-control" placeholder="Email" value="<?php echo e($soldOrder->customer_email ?? old('customer_to')); ?>">
          </div>

          <div class="form-group ">
            <input type="text" name="customer_phone" class="form-control" placeholder="Телефон" value="<?php echo e($soldOrder->customer_phone ?? old('customer_to')); ?>">
          </div>
  
          <div class="form-group">
            <label for="">Аккаунт пользователя</label>
            <select name="sale_id" class="form-control sale category  select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
              <option selected="selected" disabled data-select2-id="">Выберите пользователя</option>
              <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($user->id); ?>" <?php echo e($user->id  ? 'selected' : ''); ?>><?php echo e($user->name); ?> || id: <?php echo e($user->id); ?></option>                
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>     


          <div class="form-group">
            <label>Добавить продукт</label>
            <select class="category" id="add-product" name="add_product" style="width: 100%;">
                <!-- Опции для выбора продуктов -->
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <div class="d-flex mt-3">
              <button type="button" class="btn btn-success" id="add-btn">Добавить</button>
              <div class="text-danger mt-2 ml-3" id="error-message" style="display:none;"></div>
            </div>
            
        </div>
        
        <table class="table" id="products-table">
            <thead>
                <tr>
                    <th>Название товара</th>
                    <th>Количество</th>
                    <th>Собрано</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <!-- Товары из базы данных -->
                <?php $__currentLoopData = $orderSoldProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderSoldProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($orderSoldProduct->product->name); ?></td>
                    <td>
                        <input type="number" class="product-quantity" value="<?php echo e($orderSoldProduct->quantity); ?>"
                            data-product-id="<?php echo e($orderSoldProduct->product->id); ?>">
                    </td>
                    <td>
                        <input type="checkbox" class="product-assembled"<?php echo e($orderSoldProduct->assembled_at ? ' checked' : ''); ?>

                            data-product-id="<?php echo e($orderSoldProduct->product->id); ?>">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger delete-product"
                            data-product-id="<?php echo e($orderSoldProduct->product->id); ?>">Удалить</button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <input type="hidden" name="product_data" value="<?php echo e(json_encode($products)); ?>">
            </tbody>
        </table>
          </div>

          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Редактировать">
          </div>
        </form>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  
<script>
   document.addEventListener("DOMContentLoaded", function() {
        var products = [];

        // Заполнение массива продуктов из базы данных
        <?php $__currentLoopData = $orderSoldProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderSoldProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            products.push({
                id: "<?php echo e($orderSoldProduct->product->id); ?>",
                name: "<?php echo e($orderSoldProduct->product->name); ?>",
                quantity: <?php echo e($orderSoldProduct->quantity); ?>,
                assembled: <?php echo e($orderSoldProduct->assembled_at ? 'true' : 'false'); ?>

            });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        $(document).on('click', '#add-btn', function() {
            var productId = $('#add-product').val();
            if (productId && !isProductAdded(productId)) {
                var productName = $('#add-product option:selected').text();
                var product = {
                    id: productId,
                    name: productName,
                    quantity: 1,
                    assembled: false
                };
                products.push(product);

                renderProducts();

                $('#add-product').val('');
                $('#error-message').hide();
            } else {
                $('#error-message').text('Товар уже добавлен').show();
            }
        });

        $(document).on('click', '.delete-product', function() {
            var productId = $(this).data('product-id');
            products = products.filter(function(product) {
                return product.id !== productId;
            });

            renderProducts();
        });

        $(document).on('change', '.product-quantity', function() {
            var productId = $(this).data('product-id');
            var quantity = $(this).val();
            updateProductQuantity(productId, quantity);
        });

        $(document).on('change', '.product-assembled', function() {
            var productId = $(this).data('product-id');
            var assembled = $(this).prop('checked');
            updateProductAssembled(productId, assembled);
        });

        function isProductAdded(productId) {
            return products.some(function(product) {
                return product.id === productId;
            });
        }
        function updateProductQuantity(productId, quantity) {
            var product = getProduct(productId);
            if (product) {
                product.quantity = quantity;
            }
        }

        function updateProductAssembled(productId, assembled) {
            var product = getProduct(productId);
            if (product) {
                product.assembled = assembled;
            }
        }

        function getProduct(productId) {
            return products.find(function(product) {
                return product.id === productId;
            });
        }

        function renderProducts() {
            var tableBody = $('#products-table tbody');
            tableBody.empty();

            $.each(products, function(index, product) {
                var row = $('<tr>');
                if (product.assembled) {
                    row.addClass('assembled');
                }
                row.append(
                    $('<td>').text(product.name),
                    $('<td>').append(
                        '<input type="number" class="product-quantity" value="' + product.quantity +
                        '" data-product-id="' + product.id + '">'
                    ),
                    $('<td>').append(
                        '<input type="checkbox" class="product-assembled"' +
                        (product.assembled ? ' checked' : '') +
                        ' data-product-id="' + product.id + '">'
                    ),
                    $('<td>').append(
                        '<button type="button" class="btn btn-danger delete-product"' +
                        ' data-product-id="' + product.id + '">Удалить</button>'
                    )
                );

                tableBody.append(row);
            });
        }


        
        $(document).on('click', '.btn-primary', function() {
          event.preventDefault(); // Отменяет стандартное действие кнопки (отправку формы)

    // Получение обновленных данных из таблицы
    var products = [];
    $('#products-table tbody tr').each(function() {
        var row = $(this);
        var product = {
            id: row.find('[data-product-id]').data('product-id'),
            name: row.find('td:first-child').text(),
            quantity: parseInt(row.find('.product-quantity').val()),
            assembled: row.find('.product-assembled').prop('checked')
        };
        products.push(product);
    });

    // Создание скрытого поля и добавление данных о продуктах
    var productDataField = $('<input>').attr({
        type: 'hidden',
        name: 'product_data',
        value: JSON.stringify(products)
    });
    
    $('form').append(productDataField);

    // Продолжение отправки формы
    $('form').submit();
});


        renderProducts();

          
  });
</script>

<style>

  .checkbox.icheck label input[type="checkbox"] {
      display: none;
  }
  
  .checkbox.icheck label input[type="checkbox"] + span {
      display: inline-block;
      width: 20px;
      height: 20px;
      position: relative;
      border: 1px solid #ccc;
      background-color: #fa5050;
  }
  
  .checkbox.icheck label input[type="checkbox"] + span::before {
      content: "\2713";
      display: none;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
  }
  
  .checkbox.icheck label input[type="checkbox"]:checked + span {
      background-color: #51cd51;
  }
  
  .checkbox.icheck label input[type="checkbox"]:checked + span::before {
      display: block;
  }

    </style>

  <!-- /.content -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.statusPopUp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\maksi\Desktop\Мои_сайты\kitprotv\resources\views/admin/sale/edit.blade.php ENDPATH**/ ?>