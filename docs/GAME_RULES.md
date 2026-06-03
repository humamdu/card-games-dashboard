# Game Rules

## Trex

- Requires exactly 2 teams each with 2 player.
- Uses 4 kingdoms and 20 total rounds.
- Contract score mapping:
  - King of hearts: -75 per captured king marker.
  - Queens: -25 per queen.
  - Diamonds: -10 per diamond.
  - Collections: -15 per collection marker.
  - Trex: positive placement score supplied by the client.
- Winner is the highest score after 20 rounds.

## Tarneeb 41
- Requires exactly 4 single-player teams.
- Player bidding game.
- Winning target is 41 points.
- Bid player scores tricks on success or negative bid on failure for eache player.
- If the bidding player's pre-round score is under 30, bid-player success/failure delta is multiplied by 2.
- Ends at configurable target score, default 41 and second player in the team result >= 0; first/highest team at or over the target wins.

## Tarneeb 61

- Team bidding game.
- Winning target is 61 points.
- Bid team must reach bid amount; otherwise it loses the bid value.
- Non-bid team scores collected tricks.

## Konkan

- Team score accumulation game.
- Reaching 550 is losing condition.
- When any team reaches 550 or more, the lowest-score team is declared winner.

## Kanasah

- Team card scoring game.
- jokers kanasta bonus: 500.
- Clean kanasta bonus: 300.
- Dirty kanasta bonus: 200.
- Trisa bonus: 200.
- Joker value: 50 each, capped at 100 when 2 or more jokers are present.
- Penalties subtract from the round delta.
- Ends at configurable target score, default 5500; first/highest team at or over the target wins.
