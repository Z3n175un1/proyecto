<<?php
include "../login/conn.php";
session_start();
$usuario = $_SESSION['idusuario'] ?? 'Invitado';
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="KM - Servicios técnicos especializados en reparación de computadoras, smartphones y equipos electrónicos">
  <title>KM | Servicios Técnicos</title>
  <link rel="icon" href="../K.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #0066cc;
      --secondary-color: #ff6600;
      --dark-color: #222;
      --light-color: #f8f9fa;
      --success-color: #28a745;
      --warning-color: #ffc107;
      --danger-color: #dc3545;
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
    
    .nav-links a:hover, .nav-links a.active {
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

    /* Hero Section */
    .hero {
      background: linear-gradient(135deg, var(--primary-color) 0%, #004499 100%);
      color: white;
      padding: 5rem 2rem;
      text-align: center;
    }

    .hero-content {
      max-width: 800px;
      margin: 0 auto;
    }

    .hero h1 {
      font-size: 3.5rem;
      margin-bottom: 1.5rem;
      font-weight: 700;
      animation: fadeInUp 1s ease;
    }

    .hero p {
      font-size: 1.3rem;
      margin-bottom: 2.5rem;
      line-height: 1.6;
      opacity: 0.9;
      animation: fadeInUp 1.2s ease;
    }

    .hero-stats {
      display: flex;
      justify-content: center;
      gap: 3rem;
      margin-top: 3rem;
      animation: fadeInUp 1.4s ease;
    }

    .hero-stat {
      text-align: center;
    }

    .hero-stat-number {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--secondary-color);
      display: block;
    }

    .hero-stat-label {
      font-size: 1rem;
      opacity: 0.8;
    }

    /* Services Grid */
    .services-section {
      padding: 5rem 2rem;
      background-color: white;
    }

    .section-title {
      text-align: center;
      margin-bottom: 4rem;
    }

    .section-title h2 {
      font-size: 2.8rem;
      color: var(--dark-color);
      margin-bottom: 1rem;
      position: relative;
      display: inline-block;
    }

    .section-title h2::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: -10px;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background-color: var(--secondary-color);
    }

    .section-title p {
      color: #666;
      font-size: 1.2rem;
      max-width: 700px;
      margin: 1.5rem auto 0;
    }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 2.5rem;
      max-width: 1200px;
      margin: 0 auto;
    }

    .service-card {
      background: white;
      border-radius: 20px;
      padding: 2.5rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .service-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }

    .service-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .service-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, var(--primary-color), #004499);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      color: white;
      font-size: 2rem;
    }

    .service-card h3 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: var(--dark-color);
      font-weight: 600;
    }

    .service-card p {
      color: #666;
      font-size: 1rem;
      line-height: 1.7;
      margin-bottom: 1.5rem;
    }

    .service-features {
      list-style: none;
      padding: 0;
      margin-bottom: 2rem;
    }

    .service-features li {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      margin-bottom: 0.8rem;
      font-size: 0.95rem;
      color: #555;
    }

    .service-features i {
      color: var(--success-color);
      font-size: 0.9rem;
    }

    .service-price {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      padding-top: 1rem;
      border-top: 1px solid #f0f0f0;
    }

    .price-from {
      font-size: 0.9rem;
      color: #666;
    }

    .price-amount {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-color);
    }

    .service-btn {
      width: 100%;
      padding: 0.8rem 1.5rem;
      background: linear-gradient(135deg, var(--primary-color), #004499);
      color: white;
      border: none;
      border-radius: 30px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      font-size: 1rem;
    }

    .service-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0, 102, 204, 0.3);
    }

    /* Process Section */
    .process-section {
      padding: 5rem 2rem;
      background-color: #f8f9fa;
    }

    .process-steps {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      max-width: 1000px;
      margin: 0 auto;
    }

    .process-step {
      text-align: center;
      position: relative;
    }

    .process-step::after {
      content: '';
      position: absolute;
      top: 40px;
      right: -1rem;
      width: 2rem;
      height: 2px;
      background-color: var(--primary-color);
      opacity: 0.3;
    }

    .process-step:last-child::after {
      display: none;
    }

    .process-number {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, var(--secondary-color), #e55a00);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      color: white;
      font-size: 1.8rem;
      font-weight: 700;
    }

    .process-step h3 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
      color: var(--dark-color);
    }

    .process-step p {
      color: #666;
      line-height: 1.6;
    }

    /* Testimonials Section */
    .testimonials-section {
      padding: 5rem 2rem;
      background-color: white;
    }

    .testimonials-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      max-width: 1000px;
      margin: 0 auto;
    }

    .testimonial-card {
      background: white;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .testimonial-card::before {
      content: '"';
      font-size: 4rem;
      color: var(--primary-color);
      opacity: 0.2;
      position: absolute;
      top: 1rem;
      left: 1.5rem;
      font-family: serif;
    }

    .testimonial-text {
      font-style: italic;
      color: #555;
      line-height: 1.6;
      margin-bottom: 1.5rem;
      position: relative;
      z-index: 1;
    }

    .testimonial-author {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .author-avatar {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
    }

    .author-info h4 {
      margin: 0;
      font-size: 1.1rem;
      color: var(--dark-color);
    }

    .author-info p {
      margin: 0;
      font-size: 0.9rem;
      color: #666;
    }

    .stars {
      color: var(--warning-color);
      margin-top: 0.5rem;
    }

    /* Contact CTA Section */
    .contact-cta {
      padding: 5rem 2rem;
      background: linear-gradient(135deg, var(--dark-color) 0%, #333 100%);
      color: white;
      text-align: center;
    }

    .cta-content {
      max-width: 600px;
      margin: 0 auto;
    }

    .cta-content h2 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    .cta-content p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      opacity: 0.9;
    }

    .cta-buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-cta-primary {
      padding: 1rem 2rem;
      background-color: var(--secondary-color);
      color: white;
      border: none;
      border-radius: 30px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-cta-secondary {
      padding: 1rem 2rem;
      background-color: transparent;
      color: white;
      border: 2px solid white;
      border-radius: 30px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-cta-primary:hover {
      background-color: #e55a00;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(255, 102, 0, 0.3);
      color: white;
    }

    .btn-cta-secondary:hover {
      background-color: white;
      color: var(--dark-color);
    }

    /* Footer */
    .footer {
      background-color: var(--dark-color);
      color: white;
      padding: 4rem 2rem 2rem;
    }
    
    .footer-content {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .footer-logo {
      flex: 1;
      min-width: 300px;
    }
    
    .footer-logo h2 {
      font-size: 2.3rem;
      margin-bottom: 1rem;
      color: white;
    }
    
    .footer-logo h2 span {
      color: var(--secondary-color);
    }
    
    .footer-logo p {
      color: rgba(255, 255, 255, 0.7);
      line-height: 1.6;
      margin-bottom: 1.5rem;
    }
    
    .footer-links {
      flex: 1;
      min-width: 200px;
    }
    
    .footer-links h3 {
      font-size: 1.3rem;
      margin-bottom: 1.5rem;
      position: relative;
      display: inline-block;
    }
    
    .footer-links h3::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -10px;
      width: 40px;
      height: 3px;
      background-color: var(--secondary-color);
    }
    
    .footer-links ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .footer-links li {
      margin-bottom: 0.7rem;
    }
    
    .footer-links a {
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      transition: var(--transition);
      display: inline-block;
    }
    
    .footer-links a:hover {
      color: white;
      transform: translateX(5px);
    }
    
    .footer-contact {
      flex: 1;
      min-width: 300px;
    }
    
    .footer-contact p {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      margin-bottom: 1rem;
      color: rgba(255, 255, 255, 0.7);
    }
    
    .footer-contact i {
      color: var(--secondary-color);
    }
    
    .footer-social {
      display: flex;
      gap: 1rem;
      margin-top: 1.5rem;
    }
    
    .footer-social a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      color: white;
      transition: var(--transition);
    }
    
    .footer-social a:hover {
      background-color: var(--secondary-color);
      transform: translateY(-5px);
    }
    
    .footer-bottom {
      text-align: center;
      padding-top: 2rem;
      margin-top: 3rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      color: rgba(255, 255, 255, 0.5);
      font-size: 0.9rem;
    }

    /* Side Menu */
    .side-menu {
      position: fixed;
      top: 0;
      right: -350px;
      width: 350px;
      height: 100vh;
      background-color: white;
      box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
      z-index: 1001;
      transition: var(--transition);
      padding: 2rem;
      overflow-y: auto;
    }
    
    .side-menu.active {
      right: 0;
    }

    .menu-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: var(--transition);
    }

    .menu-overlay.active {
      opacity: 1;
      visibility: visible;
    }
    
    .menu-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid #f0f0f0;
    }

    .menu-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-color);
    }
    
    .close-btn {
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--dark-color);
      transition: var(--transition);
      background: none;
      border: none;
      padding: 0.5rem;
      border-radius: 50%;
    }
    
    .close-btn:hover {
      color: var(--secondary-color);
      background-color: #f0f0f0;
    }
    
    .menu-links {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      margin-bottom: 2rem;
    }
    
    .menu-links a {
      color: var(--dark-color);
      text-decoration: none;
      font-size: 1rem;
      font-weight: 500;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 0.8rem 1rem;
      border-radius: 10px;
      border-left: 4px solid transparent;
    }
    
    .menu-links a:hover {
      color: var(--primary-color);
      background-color: rgba(0, 102, 204, 0.05);
      border-left-color: var(--primary-color);
      transform: translateX(5px);
    }

    .menu-links a.active {
      color: var(--primary-color);
      background-color: rgba(0, 102, 204, 0.1);
      border-left-color: var(--primary-color);
    }

    .menu-links i {
      width: 20px;
      text-align: center;
    }
    
    .contact-info {
      margin-bottom: 2rem;
      padding: 1.5rem;
      background-color: #f8f9fa;
      border-radius: 10px;
    }
    
    .contact-info p {
      margin: 0.5rem 0;
      display: flex;
      align-items: center;
      gap: 0.8rem;
      color: #555;
      font-size: 0.9rem;
    }
    
    .contact-info i {
      color: var(--primary-color);
      width: 16px;
      text-align: center;
    }
    
    .contact-button {
      margin-bottom: 2rem;
    }

    .contact-button button {
      width: 100%;
      padding: 0.8rem;
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      transition: var(--transition);
      font-weight: 500;
      font-size: 0.9rem;
    }
    
    .contact-button button:hover {
      background-color: #0052a3;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 102, 204, 0.3);
    }

    .login-section {
      margin-bottom: 2rem;
    }

    .login-btn {
      display: block;
      width: 100%;
      padding: 0.8rem;
      background-color: var(--secondary-color);
      color: white;
      text-decoration: none;
      text-align: center;
      border-radius: 25px;
      font-weight: 500;
      transition: var(--transition);
    }

    .login-btn:hover {
      background-color: #e55a00;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255, 102, 0, 0.3);
    }
    
    .social-links {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 1rem;
    }
    
    .social-links a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background-color: #f0f0f0;
      border-radius: 50%;
      color: var(--dark-color);
      font-size: 1.2rem;
      transition: var(--transition);
    }
    
    .social-links a:hover {
      background-color: var(--primary-color);
      color: white;
      transform: translateY(-3px);
    }
    
    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsive */
    @media (max-width: 992px) {
      .nav-links {
        display: none;
      }
      
      .menu-icon {
        display: block;
      }
      
      .hero h1 {
        font-size: 2.8rem;
      }

      .hero-stats {
        gap: 2rem;
      }

      .services-grid {
        grid-template-columns: 1fr;
      }

      .process-steps {
        grid-template-columns: 1fr;
      }

      .process-step::after {
        display: none;
      }

      .side-menu {
        width: 300px;
        right: -300px;
      }
    }
    
    @media (max-width: 768px) {
      .hero {
        padding: 3rem 1rem;
      }
      
      .hero h1 {
        font-size: 2.3rem;
      }
      
      .hero p {
        font-size: 1.1rem;
      }

      .hero-stats {
        flex-direction: column;
        gap: 1.5rem;
      }

      .services-section,
      .process-section,
      .testimonials-section,
      .contact-cta {
        padding: 3rem 1rem;
      }

      .section-title h2 {
        font-size: 2.2rem;
      }

      .services-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .service-card {
        padding: 2rem;
      }

      .cta-buttons {
        flex-direction: column;
        align-items: center;
      }

      .side-menu {
        width: 280px;
        right: -280px;
        padding: 1.5rem;
      }
    }
    
    @media (max-width: 576px) {
      .navbar {
        padding: 1rem;
      }
      
      .logo {
        font-size: 2rem;
      }
      
      .hero h1 {
        font-size: 2rem;
      }
      
      .hero p {
        font-size: 1rem;
      }

      .section-title h2 {
        font-size: 1.8rem;
      }

      .service-card {
        padding: 1.5rem;
      }

      .cta-content h2 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="navbar">
    <a href="index.html" class="logo">K<span>M</span></a>
    
    <div class="nav-links">
      <a href="index.php">Inicio</a>
      <a href="tienda/tienda.php">Productos</a>
      <a href="servicios.php" class="active">Servicios</a>
      <a href="#">Nosotros</a>
      <a href="#">Contacto</a>
    </div>
    
    <div class="header-actions">
      <div class="user-icon">

  <!-- Poner el nombre de usuario -->
      <a href="logout.php" style="color:black; text-decoration:none;">

          <span>  <b><?php echo htmlspecialchars($usuario); ?></b></span>
        <i class="fas fa-user"></i></a>
      </div>
      <div class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
      </div>
      <div class="menu-icon" onclick="toggleMenu()">
        <i class="fas fa-bars"></i>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>Servicios Técnicos Especializados</h1>
      <p>Reparamos y mantenemos tus equipos con la máxima calidad y profesionalismo. Más de 8 años de experiencia nos respaldan.</p>
      
      <div class="hero-stats">
        <div class="hero-stat">
          <span class="hero-stat-number">1200+</span>
          <span class="hero-stat-label">Equipos Reparados</span>
        </div>
        <div class="hero-stat">
          <span class="hero-stat-number">98%</span>
          <span class="hero-stat-label">Satisfacción</span>
        </div>
        <div class="hero-stat">
          <span class="hero-stat-number">24h</span>
          <span class="hero-stat-label">Tiempo Promedio</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section class="services-section">
    <div class="section-title">
      <h2>Nuestros Servicios</h2>
      <p>Ofrecemos una amplia gama de servicios técnicos para mantener tus equipos funcionando perfectamente</p>
    </div>
    
    <div class="services-grid">
      <!-- Computer Repair Service -->
      <div class="service-card">
        <div class="service-icon">
          <i class="fas fa-laptop"></i>
        </div>
        <h3>Reparación de Computadoras</h3>
        <p>Diagnóstico y reparación completa de laptops y PCs de escritorio. Solucionamos problemas de hardware y software.</p>
        <ul class="service-features">
          <li><i class="fas fa-check"></i> Diagnóstico gratuito</li>
          <li><i class="fas fa-