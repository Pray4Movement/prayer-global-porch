# Notification System

## System Overview
A WordPress-integrated notification system using WP_Queue\Job for job management and WordPress native scheduling (wp_schedule_event) for reliable message delivery within the Prayer.Global platform.

## Core Components

### 1. System Architecture
```
notifications/
├── classes/          # Core notification classes
│   ├── jobs/        # WP_Queue job definitions
│   ├── queue/       # Queue management
│   └── templates/   # Message templates
├── handlers/        # Queue handlers
└── api/            # Notification endpoints
```

### 2. Key Technical Decisions

#### WordPress Integration
- Uses WP_Queue\Job for job management
- Implements wp_schedule_event for cron tasks
- Integrates with WordPress user system
- Implements WordPress hooks and filters

#### Queue Management
- WP_Queue for job persistence
- WordPress native scheduling
- Efficient queue processing
- Status tracking and reporting

### 3. Data Model
```php
/**
 * Core notification job
 */
class PG_Notification_Job extends WP_Queue\Job {
    public string $id;
    public string $type;        // email, system, push
    public string $recipient;
    public string $content;
    public string $status;      // pending, scheduled, sent, failed
    public DateTime $scheduled_for;
    public string $category;    // registration, streak, level_progress, prayer_relay
    public string $trigger;     // event that triggered notification
    public array $template_vars; // variables for template substitution

    public function handle(): void {
        // Job processing logic
    }
}

/**
 * Queue registration
 */
add_action('init', function() {
    wp_schedule_event(time(), 'five_minutes', 'pg_process_notification_queue');
});
```

### 4. Notification Categories
1. Registration
   - Unregistered session completion
   - App installation
   - New user registration

2. Streak & Participation
   - Daily streaks (2, 7, 14, 30, 60, 100 days)
   - Inactivity alerts (7, 14, 30, 60, 90, 180, 365 days)
   - Return after inactivity
   - Activity milestones (1, 3, 6 months, 1+ years)

3. Level & Progress
   - Location milestones (10, 50, 100, 200 locations)
   - Completion percentages (10%, 25%, 50%, 75%, 80%, 90%, 95%, 99%)
   - Lap completions (1st, 2nd, 5th, 10th)

4. Prayer Relays & Challenges
   - Custom lap events
   - Communal lap participation
   - Geographic achievements (country, continent)

## Technical Requirements

### Server Requirements
- WordPress 4.7+
- WP_Queue library
- PHP 8.2+
- MySQL 5.6+

### Performance Considerations
- Batch processing via WP_Queue
- Queue optimization
- Rate limiting
- Resource monitoring

## Security Measures
- Input validation
- Rate limiting
- Access control
- Content sanitization
- Recipient verification

## Implementation Details

### 1. Job Processing
- Queue processing hook: 'pg_process_notification_queue'
- 5-minute dispatch intervals via wp_schedule_event
- Daily cleanup via wp_schedule_event
- Failed job retry handling

### 2. Error Handling
- WP_Queue error logging
- Retry mechanism with backoff
- Alert system
- Failure tracking

### 3. Templates
- Standardized template system
- Variable substitution:
  - [UserFirstName] - User's first name
  - [LapNumber] - Number of laps completed
  - [LapName] - Custom/communal lap name
  - [LocationsPrayed] - Total locations prayed for
  - [CountryName] - Completed country name
  - [ContinentName] - Completed continent name
  - [StreakCount] - Active prayer streak
  - [FriendName] - Referred friend's name
  - [MonthlyLocations] - Monthly prayer locations
- Multi-language support
- Format validation

### 4. Delivery Channels
- Email notifications
- In-app modals
- Push notifications
- Social media mentions (for achievements)

## Testing Strategy

### Unit Tests
- Job class testing
- Queue handler testing
- Template rendering
- Error handling

### Integration Tests
- WordPress scheduling
- Queue processing
- Delivery verification
- System integration

### Performance Tests
- Queue processing speed
- Resource utilization
- Concurrent processing
- Load handling

## Monitoring and Maintenance
- Queue status monitoring
- Error rate tracking
- Performance metrics
- System health checks
