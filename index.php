<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>McDonald's Secret Deals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #ffc107;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            color: white;
            margin: 0;
            font-size: 2.5rem;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
        }
        .deals-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }
        .deal-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            padding: 20px;
        }
        .deal-card img {
            width: 100%;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .deal-card h3 {
            color: #e53935;
            font-size: 1.8rem;
            margin: 10px 0;
        }
        .deal-card p {
            color: #555;
            font-size: 1.2rem;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #e53935;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.2rem;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #d32f2f;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
        .promo-form {
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin: 20px auto;
            padding: 20px;
            max-width: 300px;
        }
        .promo-form h3 {
            color: #333;
            margin-top: 0;
        }
        .promo-form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .promo-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #ffc107;
            border: none;
            border-radius: 5px;
            color: #333;
            cursor: pointer;
            font-weight: bold;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    <h1>McDonald's Secret Deals</h1>
</header>

<div class="container">
    <section class="deals-section">
        <!-- Deal 1 -->
        <div class="deal-card">
            <img src="https://via.placeholder.com/300x200" alt="Big Mac Secret Deal">
            <h3>Big Mac for $2</h3>
            <p>Unlock this deal and enjoy a Big Mac at a special price.</p>
            <a href="#" class="btn">Claim Deal</a>
        </div>

        <!-- Deal 2 -->
        <div class="deal-card">
            <img src="https://via.placeholder.com/300x200" alt="Free Fries Deal">
            <h3>Free Fries with Purchase</h3>
            <p>Get free fries with any burger purchase. Limited time only!</p>
            <a href="#" class="btn">Claim Deal</a>
        </div>

        <!-- Deal 3 -->
        <div class="deal-card">
            <img src="https://via.placeholder.com/300x200" alt="McFlurry Deal">
            <h3>2 for 1 McFlurry</h3>
            <p>Buy one McFlurry, get the second one free! Sweet deal!</p>
            <a href="#" class="btn">Claim Deal</a>
        </div>

        <!-- Deal 4 -->
        <div class="deal-card">
            <img src="https://via.placeholder.com/300x200" alt="Breakfast Combo Deal">
            <h3>Breakfast Combo for $3</h3>
            <p>Enjoy a special breakfast combo for just $3. Morning win!</p>
            <a href="#" class="btn">Claim Deal</a>
        </div>

        <!-- Promo Code Form -->
        <div class="promo-form">
            <h3>Check Promo Code</h3>
            <form action="checkPromo.php" method="POST">
                <input type="text" name="promo_code" placeholder="Enter promo code" required>
                <input type="submit" value="Check Code">
            </form>
        </div>
    </div>
    </section>
</div>

<footer>
    <p>&copy; 2024 McDonald's. All rights reserved. | <a href="#" style="color: #ffc107;">Privacy Policy</a></p>
</footer>

</body>
</html>
