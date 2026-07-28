# Database Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    %% Core Entities
    USERS {
        bigint id PK
        string name
        string email
        string password
    }
    COURSES {
        bigint id PK
        bigint instructor_id FK
        string title
        string slug
        text description
        decimal price
        string category
        string level
        string thumbnail_url
        decimal average_rating
        string status
    }
    MODULES {
        bigint id PK
        bigint course_id FK
        string title
        integer order_index
        boolean is_remedial
    }
    LESSONS {
        bigint id PK
        bigint module_id FK
        string title
        string type
        string media_url
    }
    VIDEO_INTERACTIONS {
        bigint id PK
        bigint lesson_id FK
        integer timestamp_trigger
        json quiz_payload
    }
    ASSIGNMENTS {
        bigint id PK
        bigint lesson_id FK
        text instructions
        json rubric_json
    }
    SUBMISSIONS {
        bigint id PK
        bigint assignment_id FK
        bigint user_id FK
        string file_url
        string status
    }
    PEER_REVIEWS {
        bigint id PK
        bigint submission_id FK
        bigint reviewer_id FK
        integer score
        text feedback_comment
    }

    %% User Activity
    ENROLLMENTS {
        bigint id PK
        bigint user_id FK
        bigint course_id FK
        integer progress_percent
        string status
        timestamp enrolled_at
    }
    QUIZ_ATTEMPTS {
        bigint id PK
        bigint user_id FK
        bigint lesson_id FK
        integer score
        boolean passed
    }
    USER_BOOKMARKS {
        bigint id PK
        bigint user_id FK
        bigint lesson_id FK
        integer timestamp
        text note_text
    }
    VIDEO_WATCH_LOGS {
        bigint id PK
        bigint user_id FK
        bigint lesson_id FK
        integer watched_seconds
        integer max_timestamp_reached
    }
    DISCUSSIONS {
        bigint id PK
        bigint user_id FK
        bigint course_id FK
        bigint lesson_id FK "nullable"
        bigint parent_id FK "nullable"
        integer timestamp_context "nullable"
        text message
        integer upvotes_count
    }

    %% Gamification
    GAMIFICATION_STATS {
        bigint id PK
        bigint user_id FK
        integer current_streak
        integer total_exp
        string rank_tier
        timestamp last_login_date "nullable"
    }
    EARNED_BADGES {
        bigint id PK
        bigint user_id FK
        string badge_name
        timestamp earned_at
    }

    %% Finance
    TRANSACTION {
        bigint id PK
        bigint user_id FK
        bigint course_id FK "nullable"
        string midtrans_order_id
        string transaction_id "nullable"
        decimal amount
        string payment_method "nullable"
        string status
    }
    SUBSCRIPTIONS {
        bigint id PK
        bigint user_id FK
        string plan_name
        string status
        timestamp starts_at
        timestamp expires_at "nullable"
    }

    %% Relationships
    USERS ||--o{ COURSES : "instructs"
    USERS ||--o{ ENROLLMENTS : "has"
    USERS ||--o{ QUIZ_ATTEMPTS : "takes"
    USERS ||--o{ USER_BOOKMARKS : "creates"
    USERS ||--o{ VIDEO_WATCH_LOGS : "logs"
    USERS ||--o{ DISCUSSIONS : "writes"
    USERS ||--o{ SUBMISSIONS : "submits"
    USERS ||--o{ PEER_REVIEWS : "reviews"
    USERS ||--|| GAMIFICATION_STATS : "has"
    USERS ||--o{ EARNED_BADGES : "earns"
    USERS ||--o{ TRANSACTION : "makes"
    USERS ||--o{ SUBSCRIPTIONS : "has"

    COURSES ||--o{ MODULES : "contains"
    COURSES ||--o{ ENROLLMENTS : "has"
    COURSES ||--o{ TRANSACTION : "purchased via"
    COURSES ||--o{ DISCUSSIONS : "has"

    MODULES ||--o{ LESSONS : "contains"

    LESSONS ||--o{ VIDEO_INTERACTIONS : "has popups"
    LESSONS ||--o{ ASSIGNMENTS : "has"
    LESSONS ||--o{ QUIZ_ATTEMPTS : "has"
    LESSONS ||--o{ USER_BOOKMARKS : "bookmarked via"
    LESSONS ||--o{ VIDEO_WATCH_LOGS : "tracked by"
    LESSONS ||--o{ DISCUSSIONS : "has"

    ASSIGNMENTS ||--o{ SUBMISSIONS : "receives"

    SUBMISSIONS ||--o{ PEER_REVIEWS : "gets"
    
    DISCUSSIONS ||--o{ DISCUSSIONS : "replies to (parent_id)"
```
