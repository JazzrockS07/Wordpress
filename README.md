# Wordpress
One of my work in wordpress. Woocommerce was finalized here according to the wishes of the customer:

- the number of products displayed on the page in the store has been changed
- in chackout changed label for billing_state field
- in chackout an event onblur was added to the billing form fields, which automatically adds data to the my_field form
- added JS on the product page, which automatically shows how the filled fields on the product will look like (the product is a picture)
- filled fields on the product page are stored in the order and product meta-data
- in case of cancellation of the order, the meta-data for the product is reset to zero
- the MPDF library has been added, with the help of which a pdf file with information about the purchased product is generated during the formation of an order, this pdf file is attached to the letter to the buyer
- the letter to the buyer was changed according to the customer's template
- Changed the name of the button in the form

