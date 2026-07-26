# Skema Database LMS (Entity-Relationship Diagram)

Berikut adalah visualisasi hubungan antar tabel (relasi) dalam database LMS kita. Anda dapat melihat bagaimana tabel `users` (pengguna) terhubung ke tabel `courses` (kursus), `enrollments` (pendaftaran), pembayaran, hingga fitur gamifikasi dan diskusi.

```mermaid
erDiagram
    USERS ||--o{ COURSES : "creates (instructor)"
    USERS ||--o{ ENROLLMENTS : "has"
    USERS ||--o{ TRANSACTIONS : "makes"
    USERS ||--o{ SUBSCRIPTIONS : "has"
    USERS ||--o{ DISCUSSIONS : "writes"
    USERS ||--o{ VIDEO_WATCH_LOGS : "records"
    USERS ||--o{ SUBMISSIONS : "submits"
    USERS ||--o{ PEER_REVIEWS : "reviews"
    USERS ||--|| GAMIFICATION_STATS : "has"
    USERS ||--o{ EARNED_BADGES : "earns"

    COURSES ||--o{ MODULES : "contains"
    COURSES ||--o{ ENROLLMENTS : "has"
    COURSES ||--o{ TRANSACTIONS : "purchased via"
    COURSES ||--o{ DISCUSSIONS : "has"
    
    MODULES ||--o{ LESSONS : "contains"
    
    LESSONS ||--o{ VIDEO_WATCH_LOGS : "tracked by"
    LESSONS ||--o{ QUIZ_ATTEMPTS : "has"
    LESSONS ||--o{ DISCUSSIONS : "has"
    LESSONS ||--o{ ASSIGNMENTS : "has"
    
    ASSIGNMENTS ||--o{ SUBMISSIONS : "receives"
    
    SUBMISSIONS ||--o{ PEER_REVIEWS : "gets"

    %% Table Definitions
    USERS {
        int id PK
        string name
        string email
        string role "admin, instructor, student"
    }
    
    COURSES {
        int id PK
        int instructor_id FK
        string title
        decimal price
        string status
    }
    
    MODULES {
        int id PK
        int course_id FK
        string title
        int order
    }
    
    LESSONS {
        int id PK
        int module_id FK
        string title
        string type "video, quiz, text"
    }
    
    ENROLLMENTS {
        int id PK
        int user_id FK
        int course_id FK
        datetime enrolled_at
    }
    
    TRANSACTIONS {
        int id PK
        int user_id FK
        int course_id FK
        string status "pending, success, failed"
    }
    
    SUBSCRIPTIONS {
        int id PK
        int user_id FK
        string plan
        datetime expires_at
    }
    
    DISCUSSIONS {
        int id PK
        int user_id FK
        int course_id FK
        int lesson_id FK
        text content
    }
    
    VIDEO_WATCH_LOGS {
        int id PK
        int user_id FK
        int lesson_id FK
        int progress_seconds
        boolean is_completed
    }
    
    ASSIGNMENTS {
        int id PK
        int lesson_id FK
        string title
    }
    
    SUBMISSIONS {
        int id PK
        int assignment_id FK
        int user_id FK
        string file_url
        decimal grade
    }
    
    PEER_REVIEWS {
        int id PK
        int submission_id FK
        int reviewer_id FK
        int score
    }
    
    GAMIFICATION_STATS {
        int id PK
        int user_id FK
        int level
        int total_exp
    }
    
    EARNED_BADGES {
        int id PK
        int user_id FK
        string badge_name
    }
```

## Penjelasan Relasi Utama

1. **User & Course**: Seorang User (sebagai Instruktur) bisa membuat banyak *Course*. User (sebagai Siswa) bisa terdaftar (Enrollment) di banyak *Course*.
2. **Struktur Pembelajaran**: *Course* memiliki banyak *Modules*, dan setiap *Module* memiliki banyak *Lessons* (Video, Kuis, Materi, Tugas).
3. **Tracking & Evaluasi**: Aktivitas siswa dilacak di `VIDEO_WATCH_LOGS`, `QUIZ_ATTEMPTS`, dan `SUBMISSIONS` (untuk tugas).
4. **Keuangan**: Pembelian dicatat di `TRANSACTIONS` (kursus satuan) atau `SUBSCRIPTIONS` (berlangganan bulanan).
5. **Gamifikasi**: Data level dan poin siswa disimpan di `GAMIFICATION_STATS`, sedangkan medali/pencapaian disimpan di `EARNED_BADGES`.
