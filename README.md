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

### .env Configuration

Additionally, update the following in the `.env` file:
 
- STRIPE_KEY=
- STRIPE_SECRET=
- STRIPE_WEBHOOK_SECRET=
 
### Author

**Selvaganesh**

### License

This project is open-source and available under the MIT license.


### Working Screens
<img width="1120" alt="home_page" src="https://github.com/user-attachments/assets/36125483-52d7-4efe-81e2-0f057b389ea2" />
<img width="1120" alt="login_validation" src="https://github.com/user-attachments/assets/09b16b4f-efde-402c-b27e-9fac88d47399" />
<img width="1120" alt="register" src="https://github.com/user-attachments/assets/e51f6995-30d0-48dc-81fb-d94027c63700" />
<img width="1120" alt="login" src="https://github.com/user-attachments/assets/b0b3f7de-712a-44b6-97f0-1c67b48f4d08" />
<img width="1118" alt="after_login" src="https://github.com/user-attachments/assets/f2d2e6c8-d9bd-48f1-bf37-572148c8823f" />
<img width="1115" alt="payment_screen" src="https://github.com/user-attachments/assets/82559099-1d08-4a5a-9293-fc5cbfb8769f" />
<img width="1120" alt="card_validation" src="https://github.com/user-attachments/assets/3a8a38d6-106b-49cd-a952-beb45b39492a" />
<img width="1118" alt="processing" src="https://github.com/user-attachments/assets/e78ed69e-acf2-4f62-91e5-35e2eb914da4" />
<img width="1108" alt="cli-webhook" src="https://github.com/user-attachments/assets/51af2349-ff3b-41e9-91c8-4759cec38016" />
<img width="1120" alt="payment_success_screen" src="https://github.com/user-attachments/assets/a17ec50c-df4d-4455-aca8-34f5e28637c2" />
<img width="1120" alt="payament_failed_screen" src="https://github.com/user-attachments/assets/3ba1efb2-b732-4283-bbb1-81fa2da80455" />


