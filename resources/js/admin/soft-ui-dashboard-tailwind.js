/*!

=========================================================
* Soft UI Dashboard Tailwind - v1.0.5
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard-tailwind
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (site.license)

* Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/
export var page = window.location.pathname.split("/").pop().split(".")[0];
export const aux = window.location.pathname.split("/");
export const to_build = (aux.includes('pages')?'../':'./');
export const root = window.location.pathname.split("/")
