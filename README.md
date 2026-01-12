# JASPE – Journal of Applied Science and Practical Engineering

This is the **official website project** for JASPE, a scientific journal.  
It is a **PHP/HTML website** with MySQL backend, designed for presenting journal articles and issues. The admin panel allows managing articles, authors, institutions, and full journal editions.

## Features

- Public pages:
  - Home
  - Journal Info
  - Editorial Board
  - Editorial Policies
  - Ahead of Print
  - Archive
  - Submissions (informational only)
  - Subscription
  - Contact
- Admin-only backend for managing:
  - Journals, Volumes, and Issues
  - Articles with multiple authors and institutions
  - File uploads (articles and full issues)
- Multi-author and multi-institution support per article
- Automatic sorting of articles per issue and volume

## Project Structure

jaspe-website/
├─ public/
│ ├─ index.php # Homepage
│ ├─ uploads/
│ │ ├─ articles/ # Single article PDFs
│ │ └─ full_issues/ # Full journal PDFs
│ └─ assets/
│ ├─ css/
│ ├─ js/
│ └─ images/
├─ src/
│ ├─ config/ # DB config, constants
│ ├─ controllers/ # Controller logic
│ ├─ models/ # DB table classes
│ └─ helpers/ # Utilities (citation generator, etc.)
├─ templates/ # HTML templates (header, footer, etc.)
├─ vendor/ # Composer packages
├─ .gitignore
└─ README.md


## Installation / Setup

1. Clone the repository:

```bash
git clone <your-repo-url>
cd jaspe-website
