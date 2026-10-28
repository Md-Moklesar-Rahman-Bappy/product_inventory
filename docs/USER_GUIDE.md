# User Guide — Product Inventory Management System

## 1. Signing In
- Open the application URL.
- Enter your username and password.
- Click **Login**.

## 2. User Roles and Permissions
- **Administrator / Superadmin**: Full access to products, categories, brands, models, imports, exports, and settings.
- **Standard User**: Limited to viewing products and warranties (based on existing rules).

## 3. Creating a Product
1. Navigate to **Products > Add New Product**.
2. Fill in all required fields (marked with `*` or required validation):
   - Product Name
   - Price
   - Category
   - Brand
   - Model
   - Serial No
   - Project Serial No
3. Optional fields:
   - Position
   - User Description
   - Remarks
   - Warranty Start / End
4. Click **Create Product**.

## 4. Editing a Product
1. Open the product list.
2. Click **Edit** on the target product.
3. Update fields and click **Update Product**.

## 5. Using the Position Field
- The internal field name is `position`.
- The user-facing label is **Position**.
- Accepts text such as:
  - `ICT Section`
  - `Server Room`
  - `Rack-02`
  - `প্রকল্প পরিচালকের কক্ষ`
  - `ভূমি রেকর্ড শাখা`
- Do **not** enter numeric values; the field stores text only.

## 6. Entering Bangla Text
- Bangla (Unicode) is fully supported in:
  - Product Name
  - Category / Brand / Model
  - Serial No / Project Serial No (though these are usually alphanumeric)
  - Position
  - User Description
  - Remarks
- Ensure your spreadsheet is saved with **UTF-8 encoding** when importing.

## 7. Recommended Browser and Spreadsheet Workflow
- **Browser**: Latest Chrome, Edge, Firefox, or Safari.
- **Spreadsheet**: Microsoft Excel (2016 or newer) or LibreOffice Calc.
- **Recommended import format**: `.xlsx`

## 8. Downloading the Sample XLSX File
1. Go to **Products > Download Sample**.
2. Save `product_sample_YYYYMMDD_HHMMSS.xlsx`.
3. The file contains:
   - A **Sample Products** sheet with English and Bangla examples.
   - An **Instructions** sheet.

## 9. Preparing an Import File
- Copy the exact headings from the sample file:
  1. `product_name`
  2. `price`
  3. `category`
  4. `brand`
  5. `model`
  6. `serial_no`
  7. `project_serial_no`
  8. `position`
  9. `user_description`
  10. `remarks`
  11. `warranty_start`
  12. `warranty_end`
- Do **not** rename, reorder, or delete headings.
- Keep empty cells blank; do not insert spaces or `0` for empty text fields.

## 10. Required and Optional Fields
| Field | Required | Data Type | Constraints |
|---|---|---|---|
| product_name | Yes | Text | Max 255 chars |
| price | Yes | Numeric | Non-negative |
| category | Yes | Text | Must exist or will be created |
| brand | Yes | Text | Must exist or will be created |
| model | Yes | Text | Must exist or will be created |
| serial_no | Yes | Text | Unique |
| project_serial_no | Yes | Text | Unique |
| position | No | Text | Max 255 chars |
| user_description | No | Text | Max 1000 chars |
| remarks | No | Text | Max 1000 chars |
| warranty_start | No | Date | `d/m/Y` |
| warranty_end | No | Date | Must be >= start |

## 11. Exact Supported Headings
The import reads headings by exact name. Supported headings:
`product_name`, `price`, `category`, `brand`, `model`, `serial_no`, `project_serial_no`, `position`, `user_description`, `remarks`, `warranty_start`, `warranty_end`

## 12. Date Format Examples
- Valid: `30/05/2025`, `05/06/2026`, `2025-05-30`
- Invalid: `May 30`, `2025/05/30` (ambiguous without clear documentation)

## 13. How to Save an XLSX File
- Excel: **File > Save As > Excel Workbook (*.xlsx)**
- LibreOffice Calc: **File > Save As > Excel 2007-365 (*.xlsx)**
- Ensure the file encoding supports Unicode (default for `.xlsx`).

## 14. How to Save a UTF-8 CSV (if CSV is enabled)
- Use **Save As > CSV UTF-8 (Comma delimited)**.
- If Excel does not show UTF-8 correctly, open via **Data > Get Data > From Text/CSV** and select `65001 : Unicode (UTF-8)`.

## 15. Importing Products
1. Go to **Products > Import**.
2. Select your `.xlsx` or `.csv` file.
3. Click **Import**.
4. Read the import summary:
   - Created
   - Updated
   - Skipped
5. If rows were skipped, download the skipped rows file to review errors.

## 16. Reading Import Results
After import, a summary message shows:
- Created count
- Updated count
- Skipped count
Errors are shown per skipped row with the reason (e.g., "Invalid price", "Duplicate serial number", "Unknown category").

## 17. Correcting Failed Rows
1. Download skipped rows from the message or **Products > Skipped Rows**.
2. Fix the values in your spreadsheet (e.g., correct serial number, fix date, add missing required field).
3. Re-import the corrected file.

## 18. Exporting All Products
1. Go to **Products > Export > Excel**.
2. Download `products_YYYYMMDD_HHMMSS.xlsx`.

## 19. Exporting Products by Category
1. Go to **Categories > [Category] > Export Products**.
2. Download `products_<slug>_YYYYMMDD_HHMMSS.xlsx`.

## 20. Exporting Products by Brand
1. Go to **Brands > [Brand] > Export Products**.
2. Download the `.xlsx` file.

## 21. Exporting Products by Model
1. Go to **Models > [Model] > Export Products**.
2. Download the `.xlsx` file.

## 22. Why Blank Cells Appear
- Blank optional fields (remarks, position, warranty dates) are exported as empty cells.
- Empty cells do **not** shift other values; the column order remains fixed.

## 23. Why Values Must Not Be Moved Into Another Column
- The export uses a strict 12-column mapping based on headings.
- If you manually rearrange columns, the import will misread the data.

## 24. Troubleshooting Bangla Question Marks
- If Bangla appears as `????`: the file was saved or read with the wrong encoding.
- Solution:
  - Use `.xlsx` instead of `.csv`.
  - If using CSV, save with **UTF-8 BOM**.
  - Ensure database uses `utf8mb4` (verified by system administrator).
- Note: Data already stored as literal `?` cannot be reconstructed automatically.

## 25. Troubleshooting Position Showing as 0
- If `position` shows as `0`, the import or form converted text to a number.
- This issue is fixed; ensure you are using the updated version.
- Always enter text (e.g., `ICT Section`) in the Position field.

## 26. Troubleshooting Date Problems
- Dates must match one of the supported formats (`d/m/Y`, `m/d/Y`, `Y-m-d`).
- If a date is ambiguous (e.g., `01/02/2025`), the system uses `d/m/Y` first.
- Ensure `warranty_end` is not earlier than `warranty_start`.

## 27. Troubleshooting Duplicate Serial Numbers
- `serial_no` and `project_serial_no` must be unique per product.
- If importing a duplicate, the import updates the existing product (if enabled) or skips the row (depending on rules).
- Change the serial number in your file and re-import.

## 28. Troubleshooting Category / Brand / Model Matching
- If `category`, `brand`, or `model` does not exist, the import creates it automatically.
- If you want strict lookup validation, verify the values exist before importing.

## 29. Browser Cache and Application Cache Guidance
- If the interface behaves unexpectedly:
  1. Hard refresh (`Ctrl + F5` or `Cmd + Shift + R`).
  2. Clear browser cache.
  3. Log out and log back in.
  4. If updates were applied, run `php artisan config:clear` and `php artisan view:clear` (administrator action).

## 30. How Users Can Report a Problem
When reporting an issue, include:
- A clear description of the problem.
- The exact steps to reproduce.
- The file used (if import/export related) with a note about format (`.xlsx` or `.csv`).
- A screenshot showing the error or unexpected result.
- The browser name and version.
