# Academic Registration & Payment System

A PHP web application that lets **students** browse, register, drop, and **pay** for courses, while **teachers** can see the courses assigned to them.

## 1. Features
Student: Login, browse catalogue, enrol/drop courses, pay via external API, see on-hold list.

Teacher: Login, view assigned courses.

System: Dual data layer (live MYSQL(not complate at the moment) ***or*** hard-coded mock), idempotent card payments

---

## 2. Folder Layout
Academic Registration System/
├─ config/
│  └─ payment.php               ← API key & base URL for payment micro-service
├─ Controllers/
│  ├─ LoginController.php
│  ├─ LogoutController.php
│  └─ PaymentsController.php
├─ Classes/                     ← Domain models & data layer
│  ├─ User.php
│  ├─ Student.php
│  ├─ Teacher.php
│  ├─ DataManager.php           ← real DB (PDO)
│  ├─ DataManagerMock.php       ← fallback stubs
│  └─ PaymentApiClient.php      ← cURL helper for payment API
├─ View/                        ← Plain PHP templates (no engine)
├─ public/                      ← document root for Apache / nginx
│  ├─ index.php                 ← login gate
│  ├─ process_payment.php       ← entry point for payment POST
│  └─ …pages/                   ← the rest of the UI entry files
└─ services/                    ← external service wrappers


