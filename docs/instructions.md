# Assessment 2: the brief, condensed

Source: NIT1101 "Assessment 2.html" (LMS page), condensed 2026-11-18.
Our theme: **Music artist page → "Pink Floyd Archives"**.

## At a glance
| | |
|---|---|
| Worth | 40% |
| Group | 2 students, one submits for the group |
| Length | ~1000 words equivalent (theme reasoning, tables, screenshots, instructions, descriptions) |
| Due | Submission by **Session 10**; mandatory **individual demo in Session 11** |
| Wireframes | Teacher-signed, due end of Workshop 2 ✅ done |

The idea: start with a static site, then add JS, Bootstrap responsiveness, and a PHP + MySQL database section.
All images, videos, templates and designs must be **original to our group**. Duplicates across groups are rejected.

## 1. Site structure
- [ ] At least **6 pages**, all interlinked
- [ ] Same **nav menu on every page**: users never need the Back button
- [ ] Each page has **header, nav, main, footer**
- [ ] **One external CSS file**, linked properly on every page
- [ ] Supporting files (images, video, css, js) in **separate folders**

### Page-specific musts
**Page 1 (Home)**
- [ ] Brand logo + tagline
- [ ] Nav linking to all pages
- [ ] Image slideshow / carousel (JS or Bootstrap)
- [ ] Short intro paragraph about the brand
- [ ] At least one theme-relevant **video**

**Page 2**
- [ ] Table with **at least 4 rows** of data
- [ ] Ordered list
- [ ] External hyperlink to a relevant site
- [ ] At least one image with alt text

**Page 6 (About)**
- [ ] Description of the brand / team
- [ ] At least 3 accessibility features implemented
- [ ] Evidence of inclusive, respectful language
- [ ] Acknowledgement of Country (First Nations)
- [ ] Contact info or social links

### Must appear somewhere on the site (any page that fits)
- [ ] Relevant picture and video
- [ ] Ordered **and** unordered lists
- [ ] Tables
- [ ] **Sign-in and sign-up forms**, plus a **contact / feedback / complaint form**, all with **JavaScript validation**
- [ ] Links to relevant external pages
- [ ] Attractive descriptive paragraph with UI elements

## 2. Responsive (Bootstrap)
- [ ] Works on **mobile, tablet, and print** using Bootstrap (Session 4)

## 3. JavaScript interactivity (Session 5)
- [ ] At least **3 event types** (e.g. `click`, `submit`, `keydown`)
- [ ] At least **2 logic rules** (e.g. show/hide, toggle, calculator, dynamic content update)

## 4. Accessibility & inclusion
At least **3 features in total**: **2 or more technical** (1–4) **and 1 or more inclusion** (5–6).

| # | Feature | Type | What it means |
|---|---|---|---|
| 1 | Accessible colour scheme | technical | High contrast, no red/green combos, accessible palette |
| 2 | Read-aloud | technical | Text-to-speech button via JS `speechSynthesis` |
| 3 | Alt text | technical | Meaningful alt on all images/media |
| 4 | Keyboard access | technical | Tab navigation, accessible buttons/links, proper form `<label>`s |
| 5 | Inclusive language | inclusion | Gender-neutral ("users", "visitors"), no assumptions about culture/background |
| 6 | First Nations acknowledgement | inclusion | In footer or About page |

Example acknowledgement: *"We acknowledge the Traditional Owners of the land on which this website was created and pay our respects to Elders past and present."*

## 5. Database: PHP + MySQL (Session 9, "SneakerStore" case study)
### Required tables (exact names)
```
Categories(categoryID PK, categoryName)
Products(productID PK, categoryID, productCode, productName, listPrice)
```
- [ ] **3 categories**, with sample product data in each
- [ ] Connect the DB to a PHP page on our site

### Required operations, with a UI on one suitable page
- [ ] **SELECT**: show products (for a chosen category)
- [ ] **INSERT**: "Add" form adds a new product
- [ ] **DELETE**: Delete button per row
- [ ] **UPDATE**: Modify button hides the list and shows an edit form (name + price), then a Save button
- [ ] **ORDER BY**: two buttons, sort A→Z and Z→A
- [ ] Each sub-screen has a "View list" link back

### How the case study looks (the 8 screenshots, summarised)
```
List view                                   Add view
+-----------+  Nike                         Category [Nike v]
| Nike      |  NAME          PRICE          Code     [____]
| Adidas    |  Air Jordan 1  100.00 [Delete][Modify]   Name     [____]
| Puma      |  Nike Sports   210.00 [Delete][Modify]   Price    [____]
+-----------+  ...                          [Add Sneaker]   View Sneaker List
               Add Sneaker
               Sort Ascending / Sort Descending
Modify view: Name [Nike Airforce] Price [600.00] [Modify Sneaker]  View Sneaker List
Sort view:   same list, re-ordered, with "Add" + "View Sneaker List" links
```
The look/CSS and data must be our own (Pink Floyd themed), not sneakers.

### Concepts the marker expects to see in the code
for loop · arrays · nested if/else · PHP `include` · a stack or queue · input validation · Bootstrap · JavaScript · PHP · CSS · HTML · SQL

## 6. What to submit
- [ ] Approved wireframes ✅
- [ ] **A4 cover page**: course code, course name, assignment title, student IDs, signatures
- [ ] **Contribution report + meeting minutes**
- [ ] **Documentation**: install/usage instructions, source code, **test report with test cases**, acknowledgement of external sources
- [ ] **Zip** of the whole site folder (PHP, CSS, images, videos)
- [ ] Code includes embedded PHP, HTML, Bootstrap, JS, CSS, SQL
- [ ] All members' full names + student IDs shown clearly

## 7. Marking criteria
1. Submission & structure (runs smoothly, instructions, documentation)
2. Layout & HTML structure *(demo)*
3. JS interactivity & form validation *(demo)*
4. Accessibility & inclusion *(demo)*
5. Database functionality *(demo)*
6. Evidence: sample test cases *(demo)*
7. Written report
8. Teamwork / meeting minutes

Most criteria are judged in the **individual demo**. AI use is allowed for anything, but **you must be able to explain and defend every line**.

## 8. Wireframe vs brief: gaps to resolve
Our wireframes: Home · Albums · Tours · Signup · Fan Wall · About.
- [ ] **Home** has no **video** and shows one image rather than a **carousel**
- [ ] **Page 2 (Albums)** has an ordered list and images, but **no table (4+ rows)** and **no external link**
- [ ] The required **`Categories` / `Products`** tables need a home. Options: albums as products (categories = era or format), a merch shop, or tour tickets. Tours and fan wall can use extra tables.
- [ ] **Sign-in** form and a **contact/feedback** form are not wireframed (only Signup)
- [ ] Brief says **group of 2**: confirm partner and who does what
