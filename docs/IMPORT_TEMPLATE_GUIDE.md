# Import Template Guide

## Canonical Heading Order (12 Columns)

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

---

## Field Reference

### product_name
- User-facing name: Product Name
- Required: Yes
- Data type: Text
- Constraints: Max 255 characters
- Valid example: `ProBook 440 G11 Notebook PC`
- Invalid example: (blank)
- Bangla support: Yes — `পরীক্ষামূলক ল্যাপটপ`

### price
- User-facing name: Price
- Required: Yes
- Data type: Numeric (decimal with 2 precision)
- Constraints: Non-negative; max based on schema (10,2)
- Valid example: `157285`, `150000`, `0.00`
- Invalid example: `-100`, `abc`
- Bangla support: Numeric only

### category
- User-facing name: Category
- Required: Yes
- Data type: Text
- Constraints: Must exist or will be created automatically (`firstOrCreate`)
- Valid example: `Laptop`, `ল্যাপটপ`
- Invalid example: (blank when required by rules)
- Bangla support: Yes

### brand
- User-facing name: Brand
- Required: Yes
- Data type: Text
- Constraints: Must exist or will be created automatically
- Valid example: `HP`, `এইচপি`
- Invalid example: (blank)
- Bangla support: Yes

### model
- User-facing name: Model
- Required: Yes
- Data type: Text
- Constraints: Must exist or will be created automatically (`asset_models` table)
- Valid example: `ProBook 440 G11 Notebook PC`, `পরীক্ষামূলক মডেল`
- Invalid example: (blank)
- Bangla support: Yes

### serial_no
- User-facing name: Serial No
- Required: Yes
- Data type: Text
- Constraints: Unique per product; max 255 chars; uppercase conversion applied on import/store
- Valid example: `SAMPLE-EN-001`, `TEST-BANGLA-001`
- Invalid example: (blank), duplicate value
- Bangla support: Supported but usually alphanumeric

### project_serial_no
- User-facing name: Project Serial No
- Required: Yes
- Data type: Text
- Constraints: Unique per product; max 255 chars; uppercase conversion applied
- Valid example: `SAMPLE/PROJECT/001`, `SAMPLE/BN/001`
- Invalid example: (blank), duplicate value
- Bangla support: Supported

### position
- User-facing name: Position
- Required: No
- Data type: Text
- Constraints: Max 255 chars; must remain text (never converted to number)
- Valid example: `ICT Section`, `প্রকল্প পরিচালকের কক্ষ`, `ভূমি রেকর্ড শাখা`
- Invalid example: `0` (numeric representation of text)
- Bangla support: Yes — fully preserved

### user_description
- User-facing name: User Description
- Required: No
- Data type: Text
- Constraints: Max 1000 chars based on validation; multiline text replaced with spaces on export
- Valid example: `Assigned to maintenance team`
- Invalid example: (blank is allowed)
- Bangla support: Yes — `সহকারী রক্ষণাবেক্ষণ প্রকৌশলীর জন্য বরাদ্দ`

### remarks
- User-facing name: Remarks
- Required: No
- Data type: Text
- Constraints: Max 1000 chars; blank allowed
- Valid example: `Sample English record`, `বাংলা ইউনিকোড পরীক্ষার নমুনা`
- Invalid example: (blank is valid when optional)
- Bangla support: Yes

### warranty_start
- User-facing name: Warranty Start
- Required: No
- Data type: Date
- Constraints: Format `d/m/Y`, `m/d/Y`, or `Y-m-d`; must be between 1990 and 2099
- Valid example: `30/05/2025`, `05/06/2026`
- Invalid example: `May 30`, `2025/05/30` (ambiguous without clear rule)
- Bangla support: Not applicable (numeric/date)

### warranty_end
- User-facing name: Warranty End
- Required: No
- Data type: Date
- Constraints: Must be >= warranty_start; same format rules
- Valid example: `30/05/2026`, `05/06/2027`
- Invalid example: `30/05/2024` when start is `30/05/2025`
- Bangla support: Not applicable
