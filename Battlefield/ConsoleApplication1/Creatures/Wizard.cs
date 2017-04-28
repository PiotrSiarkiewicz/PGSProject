using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ConsoleApplication1.Creatures
{
    class Wizard : Creature
    {
        public Wizard(int xLimit, int yLimit) 
            : base(xLimit, yLimit, 'W', ConsoleColor.Red)
        {
            
        }

        public override int Attack()
        {
            MagicRegeneration();
            return _power;
        }

        private void MagicRegeneration()
        {
            _health++;
        }

        public override void GetDamage(int damage)
        {
            double immortalProbability = 0.15;
        
            if (_rnd.NextDouble() < immortalProbability)
            {
                ActivateMagicalBarrier();
            }
            else
            {
                base.GetDamage( damage);
            }
        }

        private void ActivateMagicalBarrier()
        {

        }
    }
}
