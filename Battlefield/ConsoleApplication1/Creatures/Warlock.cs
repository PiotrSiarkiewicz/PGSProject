using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ConsoleApplication1.Creatures
{
    class Warlock : Creature
    {
   
        
            public Warlock(int xLimit, int yLimit)
                : base(xLimit, yLimit, 'L', ConsoleColor.Magenta)
            {

            }

            public override int Attack()
            {
                HpDrain();
                return _power;
            }

        private void HpDrain()
        {
            _health += _power/2;
        }


        public override void GetDamage(int damage)
            {
                double sacrificeProbability = 0.25;

                if (_rnd.NextDouble() < sacrificeProbability)
                {
                     Sacrifice();
                }
                
                
                base.GetDamage(damage);
                
            }

        private void Sacrifice()
        {
            _health -=5;
            _power += 2;
        }

        

    }
}

