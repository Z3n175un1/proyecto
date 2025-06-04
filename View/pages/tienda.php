<?php 
include "../../config/conn.php"; 

// Conexión
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("❌ Error en la conexión a la base de datos.");
}

// Consulta
$sql = "SELECT item_id, numero_item, cantidad_items, nombre_producto, categoria, precio, preciobs FROM proyecto.items ORDER BY item_id";
$result = pg_query($conn, $sql);
if (!$result) {
    die("❌ Error en la consulta: " . pg_last_error($conn));
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="KM - Productos disponibles en nuestro catálogo">
  <title>KM | Productos Disponibles</title>
  <link rel="icon" href="../../public/assets/icons/login.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #0066cc;
      --secondary-color: #ff6600;
      --dark-color: #222;
      --light-color: #f8f9fa;
      --success-color: #28a745;
      --transition: all 0.3s ease;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      color: var(--dark-color);
      background-color: #f5f7fa;
      overflow-x: hidden;
    }
    
    /* Header & Navbar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    
    .logo {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--primary-color);
      text-decoration: none;
      display: flex;
      align-items: center;
    }
    
    .logo span {
      color: var(--secondary-color);
      margin-left: 2px;
    }

    .nav-links {
      display: flex;
      gap: 2rem;
    }
    
    .nav-links a {
      color: var(--dark-color);
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition);
      font-size: 1.1rem;
    }
    
    .nav-links a:hover {
      color: var(--primary-color);
    }
    
    .header-actions {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }
    
    .cart-icon, .user-icon {
      font-size: 1.3rem;
      color: var(--dark-color);
      cursor: pointer;
      transition: var(--transition);
    }
    
    .cart-icon:hover, .user-icon:hover {
      color: var(--secondary-color);
    }
    
    .menu-icon {
      display: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--dark-color);
    }

    /* Main Content */
    .main-content {
      padding: 3rem 2rem;
      max-width: 1400px;
      margin: 0 auto;
    }

    .page-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .page-header h1 {
      font-size: 2.5rem;
      color: var(--dark-color);
      margin-bottom: 1rem;
      position: relative;
      display: inline-block;
    }

    .page-header h1::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: -10px;
      transform: translateX(-50%);
      width: 70px;
      height: 4px;
      background-color: var(--secondary-color);
    }

    .page-header p {
      color: #666;
      font-size: 1.1rem;
      margin-top: 1.5rem;
    }

    /* Search and Filter Controls */
    .controls {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .search-box {
      flex: 1;
      max-width: 400px;
      position: relative;
    }

    .search-box input {
      width: 100%;
      padding: 0.8rem 1rem 0.8rem 3rem;
      border: 2px solid #e0e0e0;
      border-radius: 25px;
      font-size: 1rem;
      transition: var(--transition);
    }

    .search-box input:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
    }

    .search-box i {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
    }

    .filter-controls {
      display: flex;
      gap: 1rem;
      align-items: center;
    }

    .filter-select {
      padding: 0.7rem 1rem;
      border: 2px solid #e0e0e0;
      border-radius: 20px;
      background-color: white;
      font-size: 0.9rem;
      transition: var(--transition);
    }

    .filter-select:focus {
      outline: none;
      border-color: var(--primary-color);
    }

    /* Product Table */
    .table-container {
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      margin-bottom: 2rem;
    }

    .product-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }

    .product-table thead {
      background: linear-gradient(135deg, var(--primary-color), #004499);
    }

    .product-table th {
      padding: 1.2rem 1rem;
      text-align: left;
      font-weight: 600;
      color: white;
      font-size: 0.95rem;
      letter-spacing: 0.5px;
      border: none;
      position: relative;
    }

    .product-table th:not(:last-child)::after {
      content: '';
      position: absolute;
      right: 0;
      top: 25%;
      height: 50%;
      width: 1px;
      background-color: rgba(255, 255, 255, 0.2);
    }

    .product-table tbody tr {
      transition: var(--transition);
      border-bottom: 1px solid #f0f0f0;
    }

    .product-table tbody tr:hover {
      background-color: #f8f9fa;
      transform: scale(1.01);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .product-table td {
      padding: 1rem;
      font-size: 0.9rem;
      color: var(--dark-color);
      border: none;
    }

    .product-id {
      font-weight: 600;
      color: var(--primary-color);
    }

    .product-name {
      font-weight: 600;
      color: var(--dark-color);
    }

    .category-badge {
      display: inline-block;
      padding: 0.3rem 0.8rem;
      background-color: #e3f2fd;
      color: var(--primary-color);
      border-radius: 15px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    .price-usd {
      font-weight: 700;
      color: var(--success-color);
      font-size: 1rem;
    }

    .price-bs {
      font-weight: 600;
      color: #666;
    }

    .stock-badge {
      display: inline-block;
      padding: 0.3rem 0.8rem;
      border-radius: 15px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    .stock-high {
      background-color: #d4edda;
      color: #155724;
    }

    .stock-medium {
      background-color: #fff3cd;
      color: #856404;
    }

    .stock-low {
      background-color: #f8d7da;
      color: #721c24;
    }

    .no-products {
      text-align: center;
      padding: 3rem;
      color: #666;
      font-size: 1.1rem;
    }

    .no-products i {
      font-size: 3rem;
      color: #ccc;
      margin-bottom: 1rem;
      display: block;
    }

    /* Stats Cards */
    .stats-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      margin-bottom: 3rem;
    }

    .stat-card {
      background: white;
      padding: 1.5rem;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: var(--transition);
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
      font-size: 2.5rem;
      color: var(--primary-color);
      margin-bottom: 0.5rem;
    }

    .stat-number {
      font-size: 2rem;
      font-weight: 700;
      color: var(--dark-color);
      margin-bottom: 0.5rem;
    }

    .stat-label {
      color: #666;
      font-size: 0.9rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .nav-links {
        display: none;
      }
      
      .menu-icon {
        display: block;
      }

      .controls {
        flex-direction: column;
        align-items: stretch;
      }

      .search-box {
        max-width: none;
      }

      .filter-controls {
        justify-content: center;
      }
    }

    @media (max-width: 768px) {
      .main-content {
        padding: 2rem 1rem;
      }

      .page-header h1 {
        font-size: 2rem;
      }

      .table-container {
        overflow-x: auto;
      }

      .product-table {
        min-width: 800px;
      }

      .stats-container {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 576px) {
      .navbar {
        padding: 1rem;
      }

      .logo {
        font-size: 2rem;
      }

      .stats-container {
        grid-template-columns: 1fr;
      }

      .product-table th,
      .product-table td {
        padding: 0.8rem 0.5rem;
        font-size: 0.8rem;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="navbar">
    <a href="../index.html" class="logo">K<span>M</span></a>
    
    <div class="nav-links">
      <a href="index.html">Inicio</a>
      <a href="/logout/tienda/tienda.php" class="active">Productos</a>
      <a href="servicios.html">Servicios</a>
      <a href="#">Nosotros</a>
      <a href="#">Contacto</a>
    </div>
    
    <div class="header-actions">
      <div class="user-icon">
        <i class="fas fa-user"></i>
      </div>
      <div class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
      </div>
      <div class="menu-icon" onclick="toggleMenu()">
        <i class="fas fa-bars"></i>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Page Header -->
    <div class="page-header">
      <h1>Productos Disponibles</h1>
      <p>Explora nuestro catálogo completo de productos tecnológicos de alta calidad</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
      <?php
      // Calculate statistics
      $total_products = pg_num_rows($result);
      
      // Reset result pointer to calculate other stats
      pg_result_seek($result, 0);
      $total_stock = 0;
      $categories = [];
      
      while ($row = pg_fetch_assoc($result)) {
        $total_stock += intval($row['cantidad_items']);
        $categories[$row['categoria']] = ($categories[$row['categoria']] ?? 0) + 1;
      }
      
      $total_categories = count($categories);
      
      // Reset result pointer for table display
      pg_result_seek($result, 0);
      ?>
      
      <div class="stat-card">
        <div class="stat-icon">
          <i class="fas fa-box"></i>
        </div>
        <div class="stat-number"><?php echo $total_products; ?></div>
        <div class="stat-label">Total Productos</div>
      </div>
      
      <div class="stat-card">
        <div class="stat-icon">
          <i class="fas fa-warehouse"></i>
        </div>
        <div class="stat-number"><?php echo $total_stock; ?></div>
        <div class="stat-label">Items en Stock</div>
      </div>
      
      <div class="stat-card">
        <div class="stat-icon">
          <i class="fas fa-tags"></i>
        </div>
        <div class="stat-number"><?php echo $total_categories; ?></div>
        <div class="stat-label">Categorías</div>
      </div>
      
      <div class="stat-card">
        <div class="stat-icon">
          <i class="fas fa-star"></i>
        </div>
        <div class="stat-number">4.8</div>
        <div class="stat-label">Calificación</div>
      </div>
    </div>

    <!-- Search and Filter Controls -->
    <div class="controls">
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Buscar productos..." onkeyup="filterTable()">
      </div>
      
      <div class="filter-controls">
        <select class="filter-select" id="categoryFilter" onchange="filterTable()">
          <option value="">Todas las categorías</option>
          <?php
          foreach ($categories as $category => $count) {
            echo "<option value='" . htmlspecialchars($category) . "'>" . htmlspecialchars($category) . " ($count)</option>";
          }
          ?>
        </select>
        
        <select class="filter-select" id="stockFilter" onchange="filterTable()">
          <option value="">Todo el stock</option>
          <option value="high">Stock alto (>20)</option>
          <option value="medium">Stock medio (5-20)</option>
          <option value="low">Stock bajo (<5)</option>
        </select>
      </div>
    </div>

    <!-- Products Table -->
    <div class="table-container">
      <table class="product-table" id="productsTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>N° Item</th>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Stock</th>
            <th>Precio USD</th>
            <th>Precio Bs</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
              $stock = intval($row['cantidad_items']);
              $stock_class = '';
              
              if ($stock > 20) {
                $stock_class = 'stock-high';
              } elseif ($stock >= 5) {
                $stock_class = 'stock-medium';
              } else {
                $stock_class = 'stock-low';
              }
              
              echo "<tr>";
              echo "<td><span class='product-id'>" . htmlspecialchars($row['item_id']) . "</span></td>";
              echo "<td>" . htmlspecialchars($row['numero_item']) . "</td>";
              echo "<td><span class='product-name'>" . htmlspecialchars($row['nombre_producto']) . "</span></td>";
              echo "<td><span class='category-badge'>" . htmlspecialchars($row['categoria']) . "</span></td>";
              echo "<td><span class='stock-badge $stock_class'>" . htmlspecialchars($row['cantidad_items']) . "</span></td>";
              echo "<td><span class='price-usd'>$" . number_format(floatval($row['precio']), 2) . "</span></td>";
              echo "<td><span class='price-bs'>" . number_format(floatval($row['preciobs']), 2) . " Bs</span></td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='7' class='no-products'>";
            echo "<i class='fas fa-box-open'></i>";
            echo "No hay productos disponibles en este momento.";
            echo "</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <script>
    // Search and filter functionality
    function filterTable() {
      const searchInput = document.getElementById('searchInput').value.toLowerCase();
      const categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();
      const stockFilter = document.getElementById('stockFilter').value;
      const table = document.getElementById('productsTable');
      const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

      for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        
        if (cells.length < 7) continue; // Skip if not enough cells
        
        const productName = cells[2].textContent.toLowerCase();
        const category = cells[3].textContent.toLowerCase();
        const stockText = cells[4].textContent;
        const stockNumber = parseInt(stockText);
        
        let showRow = true;
        
        // Search filter
        if (searchInput && !productName.includes(searchInput)) {
          showRow = false;
        }
        
        // Category filter
        if (categoryFilter && !category.includes(categoryFilter)) {
          showRow = false;
        }
        
        // Stock filter
        if (stockFilter) {
          switch (stockFilter) {
            case 'high':
              if (stockNumber <= 20) showRow = false;
              break;
            case 'medium':
              if (stockNumber < 5 || stockNumber > 20) showRow = false;
              break;
            case 'low':
              if (stockNumber >= 5) showRow = false;
              break;
          }
        }
        
        row.style.display = showRow ? '' : 'none';
      }
    }

    // Menu toggle function
    function toggleMenu() {
      // Add your menu toggle logic here if needed
      console.log('Menu toggled');
    }

    // Add some interactive effects
    document.addEventListener('DOMContentLoaded', function() {
      const table = document.getElementById('productsTable');
      const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
      
      // Add click event to rows
      for (let i = 0; i < rows.length; i++) {
        rows[i].addEventListener('click', function() {
          // You can add functionality to show product details here
          console.log('Product row clicked:', this);
        });
      }
    });
  </script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Close connection
pg_close($conn);
?>