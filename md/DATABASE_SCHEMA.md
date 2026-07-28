# Database Schema & Structure

## 1. Academic Core

### `courses`
- `id` (PK)
- `instructor_id` (FK to users)
- `title` (string)
- `slug` (string, unique)
- `description` (text, nullable)
- `price` (decimal 10,2, default 0)
- `category` (string)
- `level` (enum: beginner, intermediate, advanced)
- `thumbnail_url` (string, nullable)
- `average_rating` (decimal 2,1, default 0.0)
- `status` (enum: draft, published)
- timestamps

### `modules`
- `id` (PK)
- `course_id` (FK to courses)
- `title` (string)
- `order_index` (integer, default 0)
- `is_remedial` (boolean, default false)
- timestamps

### `lessons`
- `id` (PK)
- `module_id` (FK to modules)
- `title` (string)
- `type` (enum: video, quiz, text, assignment)
- `media_url` (string, nullable)
- timestamps

### `video_interactions`
- `id` (PK)
- `lesson_id` (FK to lessons)
- `timestamp_trigger` (integer, default 0)
- `quiz_payload` (json, nullable)
- timestamps

### `assignments`
- `id` (PK)
- `lesson_id` (FK to lessons)
- `instructions` (text)
- `rubric_json` (json, nullable)
- timestamps

### `submissions`
- `id` (PK)
- `assignment_id` (FK to assignments)
- `user_id` (FK to users)
- `file_url` (string, nullable)
- `status` (enum: submitted, reviewed)
- timestamps

### `peer_reviews`
- `id` (PK)
- `submission_id` (FK to submissions)
- `reviewer_id` (FK to users)
- `score` (integer, default 0)
- `feedback_comment` (text, nullable)
- timestamps

## 2. User Activity & Tracking

### `enrollments`
- `id` (PK)
- `user_id` (FK to users)
- `course_id` (FK to courses)
- `progress_percent` (integer, default 0)
- `status` (enum: active, completed, dropped)
- `enrolled_at` (timestamp)
- timestamps

### `quiz_attempts`
- `id` (PK)
- `user_id` (FK to users)
- `lesson_id` (FK to lessons)
- `score` (integer, default 0)
- `passed` (boolean, default false)
- timestamps

### `user_bookmarks`
- `id` (PK)
- `user_id` (FK to users)
- `lesson_id` (FK to lessons)
- `timestamp` (integer, default 0)
- `note_text` (text, nullable)
- timestamps

### `video_watch_logs`
- `id` (PK)
- `user_id` (FK to users)
- `lesson_id` (FK to lessons)
- `watched_seconds` (integer, default 0)
- `max_timestamp_reached` (integer, default 0)
- timestamps

### `discussions`
- `id` (PK)
- `user_id` (FK to users)
- `course_id` (FK to courses)
- `lesson_id` (FK to lessons, nullable)
- `parent_id` (FK to discussions, nullable)
- `timestamp_context` (integer, nullable)
- `message` (text)
- `upvotes_count` (integer, default 0)
- timestamps

## 3. Gamification

### `gamification_stats`
- `id` (PK)
- `user_id` (FK to users, unique)
- `current_streak` (integer, default 0)
- `total_exp` (integer, default 0)
- `rank_tier` (string, default 'bronze')
- `last_login_date` (timestamp, nullable)
- timestamps

### `earned_badges`
- `id` (PK)
- `user_id` (FK to users)
- `badge_name` (string)
- `earned_at` (timestamp)
- timestamps

## 4. Finance / Monetization

### `transaction`
- `id` (PK)
- `user_id` (FK to users)
- `course_id` (FK to courses, nullable)
- `midtrans_order_id` (string, unique)
- `transaction_id` (string, nullable)
- `amount` (decimal 10,2)
- `payment_method` (string, nullable)
- `status` (enum: pending, success, failed)
- timestamps

### `subscriptions`
- `id` (PK)
- `user_id` (FK to users)
- `plan_name` (string)
- `status` (enum: active, expired, cancelled)
- `starts_at` (timestamp)
- `expires_at` (timestamp, nullable)
- timestamps
