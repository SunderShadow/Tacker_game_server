# API

* [Before lobby](#before-lobby)
* [In lobby](#in-lobby)

## Before lobby
***

## User actions

### Create lobby

#### Payload
```json
{
  "action": "lobby:create"
}
```

#### Returns
```json
{
  "action":  "lobby:create:success",
  "data": {
    "id": 312 // Lobby_id
  }
}
```
---

### Join lobby

#### Payload
```json
{
  "action": "lobby:join",
  "data": {
    "id": 312 // Lobby_id
  }
}
```

#### Returns
```json
{
  "action":  "lobby:join:success"
}
```


## In lobby
***

## User actions

### Start game

#### Payload
```json
{
  "action": "lobby:start",
  "data": {
    "id": 312 // Lobby_id
  }
}
```

#### Returns
```json
{
  "action":  "game:state:prepare-cards"
}
```

## Prepare cards game state
***

## User actions

### Fill card

#### Payload
```json
{
  "action": "card:fill",
  "data":  ['some_template_to_fill']
}
```

## Server actions

### Send card to user

```json
{
  "action": "card:receive",
  "data": {
    "template": "Some ___ template" 
  }
}
```

### Change state to battle

```json
{
  "action":  "game:state:battle"
}
```

## Battle
***

## User actions

### Vote

#### Payload
```json
{
  "action": "vote",
  "data":  {
    "id": 12 // opponent ID that user are voting for
  }
}
```

#### Returns
```json
{
  "action": "vote",
  "data":  {
    "from": 18 // voted user ID 
    "to": 12   // opponent ID
  }
}
```

## Server actions

### Send opponents pair of cards

```json
{
  "action": "battle:cards",
  "data": [
    {
      "owner_id": 12,
      "template": "first May__be-Filled template"
    },
    {
      "owner_id": 14,
      "template": "second may-be_filled template"
    }
  ]
}
```

### Battle end

```json
{
  "action": "battle:end"
}
```