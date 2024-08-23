# Back-end Interview Practical

## Instructions

The website in this repository has many bugs and hasn't been written very well. The parts below are designed to test how you address these problems and add new features.

Please refer to [https://laravel.com/docs/9.x/installation](https://laravel.com/docs/9.x/installation) for more details on setting up a Laravel project. If you're stuck, feel free to also let us know, and we'll help you out!

## Notes

- Please clone this repository, and perform the tasks below.
- We are *not* worried about page layout or styling.
- ***Please commit your changes and send us a .zip copy (including the .git directory).***

## Part 1
- Improve the routing used in the site.
- Add validation to the new product process and make sure the product's name is unique.

## Part 2
- Fix any security issues you notice in the ProductController.
- Fix any security issues or bugs, and make improvements to the blade template (*don't worry about layout and styling*).

## Part 3
Currently, the "description" field in the form doesn't do anything.
- Please update the products table to include a "description" field, and populate it from this form.

## Part 4
Currently, the "tags" field in the form doesn't do anything. We would like to create tags for new products:
- Create a new Tag model, and a new pivot table to link the Products to the Tags (many-to-many).
- Take the tags string when the form is submitted and split it by commas.
- Create a tag for each save it - but only if it's unique.
- Link the product to each one (whether the tags were new or existed from before).
