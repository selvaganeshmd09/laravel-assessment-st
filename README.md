## Sumanas Technologies: Laravel Assessment Task

### Project Overview

This project is a Laravel-based e-commerce platform that integrates Stripe for payment processing. The application follows a simple workflow to enable users to browse products, log in, and make purchases securely using Stripe.

### Project Flow

1. **Default Page:** Displays products.
2. **Login Requirement:** If a user clicks "Buy Now" without logging in, a prompt alert appears.
3. **Purchase Process:** users can purchase a product once logged in.
4. **Payment Page:** Users must enter a valid Stripe test card.
5. **Validation:** The card details are validated before processing.
6. **Charge via Stripe:** The product is charged using Stripe.
7. **Success Page:** Redirects to a success page upon successful payment.
8. **Error Handling:** Redirects to an error page if any issues occur.
 

### Stripe Webhook Setup

1. Install Stripe CLI and log in.
2. Use ngrok to expose the local webhook endpoint.
3. Register the webhook URL in Stripe Dashboard.
4. Run Stripe CLI to listen for events:
   ```sh
   stripe listen --forward-to http://127.0.0.1:8000/webhook
   ```

### Technologies Used

- Laravel
- PHP 8+
- Laravel 9
- Stripe API
- MySQL
- Bootstrap 5

### Author

**Selvaganesh**

### License

This project is open-source and available under the MIT license.

